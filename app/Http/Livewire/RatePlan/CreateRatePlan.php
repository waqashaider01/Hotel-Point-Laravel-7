<?php

namespace App\Http\Livewire\RatePlan;

use App\Models\HotelSetting;
use App\Models\RateType;
use App\Models\RateTypeCancellationPolicy;
use App\Models\RateTypeCategory;
use App\Models\RoomType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateRatePlan extends Component
{
    public HotelSetting $hotel;
    public Collection $rate_type_categories;
    public Collection $rate_type_policies;
    public Collection $room_types;
    public Collection $rate_types;
    public RateType $rate_type;
    public RoomType $selected_room_type;
    public RateTypeCategory $selected_rate_type_category;
    public RateTypeCancellationPolicy $selected_cancellation_policy;
    public $max_occupancy = 0;
    public $channex_rate_plan;
    public $parent_channex_rate_plan;
    public bool $editing;

    public $rate_plan = [
        'name' => '',
        'cancellation_amount_symbol' => 'Nights',
        'rate_type' => 'manual',
        'sell_mode' => 'per_room',
        'rate_mode' => 'manual',
        'primary_occupancy' => 1,
        'occupancy_logic' => '',
        'cancellation_info'=>'How many nights will be charged for cancellation',
    ];

    protected $messages = [
        'rate_plan.name.not_in' => 'The name is already in use!',
        'rate_plan.reference_code.not_in' => 'The reference code is already in use!',
        'rate_plan.occupancy_logic.required' => "Please fill out the rate logic!"

    ];

    protected function rules()
    {
        return [
            'rate_plan.name' => ['required', 'string', 'min:3', 'max:255', Rule::notIn($this->rate_types->where('name', '!=', $this->rate_plan->name)->pluck('name'))],
            'rate_plan.room_type_id' => ['required', 'numeric', Rule::in($this->room_types->pluck('id'))],
            'rate_plan.reference_code' => ['required', 'string', Rule::notIn($this->rate_types->where('reference_code', '!=', $this->rate_plan->reference_code)->pluck('reference_code'))],
            'rate_plan.reservation_rate' => ['required', 'numeric', 'min:0'],
            'rate_plan.meal_category' => ['required', 'numeric', Rule::in($this->rate_type_categories->pluck('id'))],
            'rate_plan.description_to_document' => ['required', 'string', 'min:3', 'max:255'],
            'rate_plan.rate_percentage' => ['required_without:rate_plan.rate_amount', 'nullable', 'numeric', 'min:0', 'max:100'],
            'rate_plan.rate_amount' => ['required_without:rate_plan.rate_percentage', 'nullable', 'numeric', 'min:0',],
            'rate_plan.prepayment' => ['required', 'numeric', 'min:0', 'max:100'],
            'rate_plan.charge' => ['required', 'numeric', 'min:0', 'max:100'],
            'rate_plan.reservation_charge_days' => ['required', 'numeric', 'min:0', 'max:100'],
            'rate_plan.charge2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'rate_plan.reservation_charge_days_2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'rate_plan.cancellation_policy_id' => ['required', 'numeric', Rule::in($this->rate_type_policies->pluck('id'))],
            'rate_plan.cancellation_charge' => ['required', 'numeric', 'min:0'],
            'rate_plan.cancellation_charge_days' => ['required', 'numeric', 'min:0'],
            'rate_plan.early_checkout_charge_percentage' => ['required', 'numeric', 'min:0'],
            'rate_plan.no_show_charge_percentage' => ['required', 'numeric', 'min:0'],
            'rate_plan.rate_type' => ['required', 'string', Rule::in(['manual', 'derived'])],
            'rate_plan.parent_rate_plan_id' => [Rule::requiredIf($this->rate_plan['rate_type'] == 'derived'), 'nullable', 'numeric', Rule::in($this->rate_types->pluck('id'))],
            'rate_plan.sell_mode' => ['required', 'string', Rule::in(['per_room', 'per_person'])],
            'rate_plan.rate_mode' => [
                Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person'),
                'nullable',
                'string',
                Rule::in($this->rate_plan['rate_type'] == 'manual' ? ['manual', 'derived', 'auto']:['auto', 'derived', 'cascade'])
            ],
            'rate_plan.primary_occupancy' => [
                Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person' && in_array($this->rate_plan['rate_mode'], ['derived', 'auto'])),
                'nullable',
                'numeric',
                'min:1',
                'max:'.$this->max_occupancy,
            ],
            'rate_plan.occupancy_logic' => [
                Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person' && $this->rate_plan['sell_price_type'] == 'derived'),
                'nullable',
                'array',
                // 'size:'.($this->max_occupancy - 1),
            ],
            'rate_plan.occupancy_logic.*.modifier' => [
                Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person' && $this->rate_plan['sell_price_type'] == 'derived'),
                'nullable',
                'string',
                Rule::in(['increase_by_amount', 'decrease_by_amount', 'increase_by_percent', 'decrease_by_percent']),
            ],
            'rate_plan.occupancy_logic.*.value' => [
                Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person' && $this->rate_plan['sell_price_type'] == 'derived'),
                'nullable',
                'numeric',
                'min:0',
            ],
            
            'rate_plan.cascade_select_type' => [
                Rule::requiredIf($this->rate_plan['rate_mode'] == 'cascade'),
                'nullable',
                'string',
                Rule::in(['increase_by_amount', 'decrease_by_amount', 'increase_by_percent', 'decrease_by_percent']),
            ],
            'rate_plan.cascade_select_value' => [
                Rule::requiredIf($this->rate_plan['rate_mode'] == 'cascade'),
                'nullable',
                'numeric',
                'min:0'
            ],
            'rate_plan.children_fee' => [Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person'), 'nullable', 'numeric', 'min:0'],
            'rate_plan.infant_fee' => [Rule::requiredIf($this->rate_plan['sell_mode'] == 'per_person'), 'nullable', 'numeric', 'min:0'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        /**
         * Rate Percentage & Amount updates
         */
        if ($propertyName == 'rate_plan.rate_percentage') {
            $this->rate_plan['rate_amount'] = null;
        }
        if ($propertyName == 'rate_plan.rate_amount') {
            $this->rate_plan['rate_percentage'] = null;
        }
    }

    public function mount($rate_plan)
    {
        
        $this->hotel = getHotelSettings();
        $this->hotel->load(['currency', 'rate_type_categories', 'rate_types']);
        $this->rate_types = $this->hotel->rate_types;
        $this->rate_type_categories  = $this->hotel->rate_type_categories;
        $this->rate_type_policies  = $this->hotel->rate_type_cancellation_policies;
        $this->room_types  = $this->hotel->room_types;

        $this->editing = $rate_plan != null;
        // dd($this->editing);
       
        if ($rate_plan) {
            $this->rate_type = $rate_plan;
            $this->rate_plan=$rate_plan;
            // $this->rate_plan->room_type_id=$rate_plan->room_type_id;
            $this->rate_plan->meal_category=$rate_plan->rate_type_category_id;
            $this->rate_plan->cancellation_policy_id=$rate_plan->rate_type_cancellation_policy_id;
            $this->selected_room_type=RoomType::where('id', $rate_plan->room_type_id)->first();
            $this->roomTypeUpdated();
            $this->rateTypeCategoryUpdated();
            $this->cancellationPolicyUpdated();
            if ($rate_plan->charge_type==0) {
                $this->rate_plan->rate_percentage=$rate_plan->charge_percentage;
            }else{
                $this->rate_plan->rate_amount=$rate_plan->charge_percentage;
            }

            if ($rate_plan->parent_rate_plan_id) {
                $this->rate_plan->rate_type="derived";
            } else {
                $this->rate_plan->rate_type="manual";
            }
            

        } else {
            $this->rate_type = new RateType();
            $this->rate_plan=new RateType();
            $this->rate_type->hotel_settings_id = $this->hotel->id;
            // $this->rate_plan->rate_type='manual';
            $this->selected_room_type = new RoomType();
        }

        
        
    }

    public function render()
    {
        return view('livewire.rate-plan.create-rate-plan');
    }

    public function roomTypeUpdated()
    {
        try {
            $this->selected_room_type = $this->room_types->where('id', $this->rate_plan['room_type_id'])->first();
            $this->max_occupancy = $this->selected_room_type->adults_channex ?? $this->selected_room_type->rooms()->first()->max_adults;
            $this->rate_plan['primary_occupancy'] = $this->selected_room_type->default_occupancy_channex;
        } catch (\Throwable $th) {
            $this->selected_room_type = new RoomType();
        }
    }

    public function rateTypeCategoryUpdated()
    {
        try {
            $this->selected_rate_type_category = $this->rate_type_categories->where('id', $this->rate_plan['meal_category'])->first();
            $this->rate_plan['description_to_document'] = $this->selected_rate_type_category->desc_to_document;
            $this->rate_plan['rate_percentage'] = $this->selected_rate_type_category->charge_percentage;
            $this->rate_plan['rate_amount'] = null;
            $this->resetErrorBag('rate_plan.description_to_document');
            $this->resetErrorBag('rate_plan.rate_percentage');
            $this->resetErrorBag('rate_plan.rate_amount');
        } catch (\Throwable $th) {
            $this->selected_rate_type_category = new RateTypeCategory();
        }
    }

    public function cancellationPolicyUpdated()
    {
        try {
            $this->selected_cancellation_policy = $this->rate_type_policies->where('id', $this->rate_plan['cancellation_policy_id'])->first();
            switch ($this->selected_cancellation_policy->type) {
                case 1:
                    $this->rate_plan['cancellation_amount_symbol'] = "Nights";
                    $this->rate_plan['cancellation_info']='How many nights will be charged for cancellation';
                    break;
                case 2:
                    $this->rate_plan['cancellation_amount_symbol'] = "%";
                    $this->rate_plan['cancellation_info']='How much percentage will be charged for cancellation';
                    break;
                case 3:
                    $this->rate_plan['cancellation_amount_symbol'] = $this->hotel->currency->symbol;
                    $this->rate_plan['cancellation_info']='How much standard amount will be charged for each reservation';
                    break;
                case 4:
                    $this->rate_plan['cancellation_amount_symbol'] = $this->hotel->currency->symbol;
                    $this->rate_plan['cancellation_info']='How much standard amount will be charged for each room type';
                    break;

                default:
                    $this->rate_plan['cancellation_amount_symbol'] = 'Nights';
                    $this->rate_plan['cancellation_info']='How many nights will be charged for cancellation';
                    break;
            }
        } catch (\Throwable $th) {
            $this->emit('showWarning', $th->getMessage());
            $this->rate_plan['cancellation_amount_symbol'] = 'AB';
        }
    }

    public function submitRatePlan()
    {
        $this->validate();
        $this->prepareRatePlanForSave();

        $data = $this->dataForChannex();
        $url=config('services.channex.api_base') . '/rate_plans'.'/'. $this->rate_type->channex_id;
        
        try {
            
            if ($this->editing) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->put(config('services.channex.api_base') . '/rate_plans/'. $this->rate_type->channex_id, $data);
            }else{
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'user-api-key' => config('services.channex.api_key'),
                ])->post(config('services.channex.api_base') . '/rate_plans', $data);
            }
            

            $response->throw();

            $rate_channex_id = $response->json('data')['id'];
            if ($rate_channex_id) {
                $this->rate_type->channex_id = $rate_channex_id;
            } else {
                throw new \Exception("Rate plan id not returned from channex!", 1);
            }


            $this->rate_type->save();
            session()->flash('success', "The rate plan has been created successfully!");
            return $this->redirectRoute('rate-plans.index');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }

    public function prepareRatePlanForSave()
    {
        $this->rate_type->hotel_settings_id = $this->hotel->id;
        if (!$this->editing) {
            $this->rate_type->channex_id = 'NA';
        }
        
        $this->rate_type->name = $this->rate_plan['name'];
        $this->rate_type->status = 1;
        $this->rate_type->reservation_rate = $this->rate_plan['reservation_rate'];
        $this->rate_type->charge = $this->rate_plan['charge'];
        $this->rate_type->reservation_charge_days = $this->rate_plan['reservation_charge_days'];
        $this->rate_type->charge2 = $this->rate_plan['charge2'] ?? 0;
        $this->rate_type->reservation_charge_days_2 = $this->rate_plan['reservation_charge_days_2'] ?? 0;

        if ($this->rate_plan['rate_percentage']) {
            $this->rate_type->charge_type = 0;
            $this->rate_type->charge_percentage = $this->rate_plan['rate_percentage'];
        } else {
            $this->rate_type->charge_type = 1;
            $this->rate_type->charge_percentage = $this->rate_plan['rate_amount'];
        }

        $this->rate_type->no_show_charge_percentage = $this->rate_plan['no_show_charge_percentage'];
        $this->rate_type->early_checkout_charge_percentage = $this->rate_plan['early_checkout_charge_percentage'];
        $this->rate_type->description_to_document = $this->rate_plan['description_to_document'];
        $this->rate_type->prepayment = $this->rate_plan['prepayment'];
        $this->rate_type->room_type_id = $this->rate_plan['room_type_id'];
        $this->rate_type->rate_type_category_id = $this->rate_plan['meal_category'];
        $this->rate_type->primary_occupancy = $this->rate_plan['primary_occupancy'];
        $this->rate_type->parent_rate_plan_id = $this->rate_plan['parent_rate_plan_id'] ?? null;
        $this->rate_type->sell_mode = $this->rate_plan['sell_mode'];
        $this->rate_type->rate_mode = $this->rate_plan['rate_mode'];
        $this->rate_type->cancellation_charge = $this->rate_plan['cancellation_charge'];
        $this->rate_type->cancellation_charge_days = $this->rate_plan['cancellation_charge_days'];
        $this->rate_type->reference_code = $this->rate_plan['reference_code'];
        $this->rate_type->rate_type_cancellation_policy_id = $this->rate_plan['cancellation_policy_id'];
        $this->rate_type->children_fee = $this->rate_plan['children_fee'] ?? 0;
        $this->rate_type->infant_fee = $this->rate_plan['infant_fee'] ?? 0;
        $this->rate_type->cascade_select_type = $this->rate_plan['cascade_select_type'] ?? null;
        $this->rate_type->cascade_select_value = $this->rate_plan['cascade_select_value'] ?? null;
        $this->rate_type->occupancy_logic = $this->rate_plan['occupancy_logic'] ?? [];
    }

    public function dataForChannex()
    {
        $derived_rates = [];
        if ($this->rate_type->rate_mode == "derived") {
            foreach ($this->rate_type->occupancy_logic as $key => $value) {
                if ($value['modifier'] && $key>0) {
                    array_push($derived_rates, [$key, $value['modifier'], $value['value']]);
                }
                
            }
        }
   
        $max_occupancy = $this->max_occupancy;

        if ($this->rate_type->parent_rate_plan_id) {
            $parent_rate = getHotelSettings()->rate_types()->find($this->rate_type->parent_rate_plan_id);
            if ($this->rate_type->rate_mode == "derived" && $this->rate_type->sell_mode == "per_person") {
                $optionsArray = array();
                $option = [
                    "occupancy" => (int)$this->rate_type->primary_occupancy,
                    "is_primary" => true,
                    "rate" => $this->rate_type->reservation_rate
                ];
                array_push($optionsArray, $option);

                for ($i = 0; $i < count($derived_rates); $i++) {
                    $option = [
                        "occupancy" => $derived_rates[$i][0],
                        "is_primary" => false,
                        "rate" => $this->rate_type->reservation_rate,
                        "derived_option" => [
                            "rate" => [
                                [
                                    $derived_rates[$i][1], $derived_rates[$i][2]
                                ]

                            ]

                        ]


                    ];
                    array_push($optionsArray, $option);
                }

                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => $parent_rate->channex_id,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee,
                        "options" => $optionsArray,
                        "inherit_rate" => true,
                        "inherit_closed_to_arrival" => true,
                        "inherit_closed_to_departure" => true,
                        "inherit_stop_sell" => true,
                        "inherit_min_stay_arrival" => true,
                        "inherit_min_stay_through" => true,
                        "inherit_max_stay" => true,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "derived" && $this->rate_type->sell_mode == "per_room") {
                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => $parent_rate->channex_id,
                        "options" => [
                            [
                                "occupancy" => (int)$max_occupancy,
                                "is_primary" => true,
                                "rate" => $this->rate_type->reservation_rate
                            ]

                        ],
                        "inherit_rate" => true,
                        "inherit_closed_to_arrival" => true,
                        "inherit_closed_to_departure" => true,
                        "inherit_stop_sell" => true,
                        "inherit_min_stay_arrival" => true,
                        "inherit_min_stay_through" => true,
                        "inherit_max_stay" => true,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "auto" && $this->rate_type->sell_mode == "per_person") {
                $autoratesarray = array();

                for ($i = 1; $i <= $max_occupancy; $i++) {
                    if ($i == $this->rate_type->primary_occupancy) {
                        $option = [
                            "occupancy" => $i,
                            "is_primary" => true,
                            "rate" => $this->rate_type->reservation_rate

                        ];
                        array_push($autoratesarray, $option);
                    } else {
                        $option = [
                            "occupancy" => $i,
                            "is_primary" => false,
                            "rate" => $this->rate_type->reservation_rate

                        ];
                        array_push($autoratesarray, $option);
                    }
                }



                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => $parent_rate->channex_id,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee,
                        "options" => $autoratesarray,
                        "inherit_rate" => true,
                        "inherit_closed_to_arrival" => true,
                        "inherit_closed_to_departure" => true,
                        "inherit_stop_sell" => true,
                        "inherit_min_stay_arrival" => true,
                        "inherit_min_stay_through" => true,
                        "inherit_max_stay" => true,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "cascade" && $this->rate_type->sell_mode == "per_person") {
                $optionsArray = array();
                for ($i = 1; $i <= $max_occupancy; $i++) {
                    if ($i == $this->rate_type->primary_occupancy) {
                        $option = [
                            "occupancy" => (int)$this->rate_type->primary_occupancy,
                            "is_primary" => true,
                            "rate" => $this->rate_type->reservation_rate,
                            "derived_option" => [
                                "rate" => [
                                    [
                                        $this->rate_type->cascade_select_type, $this->rate_type->cascade_select_value
                                    ]

                                ]

                            ]
                        ];
                        array_push($optionsArray, $option);
                    } else {
                        $option = [
                            "occupancy" => $i,
                            "is_primary" => false,
                            "rate" => $this->rate_type->reservation_rate,
                            "derived_option" => [
                                "rate" => [
                                    [
                                        $this->rate_type->cascade_select_type, $this->rate_type->cascade_select_value
                                    ]

                                ]

                            ]

                        ];
                        array_push($optionsArray, $option);
                    }
                }

                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => $parent_rate->channex_id,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee,
                        "options" => $optionsArray,
                        "inherit_rate" => true,
                        "inherit_closed_to_arrival" => true,
                        "inherit_closed_to_departure" => true,
                        "inherit_stop_sell" => true,
                        "inherit_min_stay_arrival" => true,
                        "inherit_min_stay_through" => true,
                        "inherit_max_stay" => true,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode
                    ]

                ];
            } else {
            }
        } else {
            $optionsArray = array();
            for ($i = 1; $i <= $max_occupancy; $i++) {
                if ($i == $this->rate_type->primary_occupancy) {
                    $option = [
                        "occupancy" => (int)$this->rate_type->primary_occupancy,
                        "is_primary" => true,
                        "rate" => $this->rate_type->reservation_rate
                    ];
                    array_push($optionsArray, $option);
                } else {
                    $option = [
                        "occupancy" => $i,
                        "is_primary" => false,
                        "rate" => $this->rate_type->reservation_rate,

                    ];
                    array_push($optionsArray, $option);
                }
            }



            if ($this->rate_type->rate_mode == "manual" && $this->rate_type->sell_mode == "per_person") {
                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => null,
                        "options" => $optionsArray,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "manual" && $this->rate_type->sell_mode == "per_room") {
                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => null,
                        "options" => [
                            [
                                "occupancy" => (int)$max_occupancy,
                                "is_primary" => true,
                                "rate" => $this->rate_type->reservation_rate
                            ]

                        ],
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode

                    ]

                ];
            } else if ($this->rate_type->rate_mode == "auto" && $this->rate_type->sell_mode == "per_person") {
                $autoratesarray = array();
                $autorateoptions = [
                    "occupancy" => (int)$this->rate_type->primary_occupancy,
                    "is_primary" => true,
                    "rate" => $this->rate_type->reservation_rate,
                ];
                array_push($autoratesarray, $autorateoptions);
                // $increaserate=$increasevalue;
                // $increaseStart=$this->rate_type->primary_occupancy+1;
                // $decreaseStart=$this->rate_type->primary_occupancy-1;
                // $decreaserate=$decreasevalue;
                for ($i = 1; $i <= $max_occupancy; $i++) {
                    if ($i == $this->rate_type->primary_occupancy) {
                        $option = [
                            "occupancy" => $i,
                            "is_primary" => true,
                            "rate" => $this->rate_type->reservation_rate



                        ];
                        array_push($autoratesarray, $option);
                    } else {

                        $option = [
                            "occupancy" => $i,
                            "is_primary" => false,
                            "rate" => $this->rate_type->reservation_rate,



                        ];
                        array_push($autoratesarray, $option);
                    }
                }

                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => null,
                        "options" => $autoratesarray,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "derived" && $this->rate_type->sell_mode == "per_person") {
                $optionsArray = array();
                $option = [
                    "occupancy" => (int)$this->rate_type->primary_occupancy,
                    "is_primary" => true,
                    "rate" => $this->rate_type->reservation_rate
                ];
                array_push($optionsArray, $option);
                for ($i = 0; $i < count($derived_rates); $i++) {

                    $option = [
                        "occupancy" => $derived_rates[$i][0],
                        "is_primary" => false,
                        "rate" => $this->rate_type->reservation_rate,
                        "derived_option" => [
                            "rate" => [
                                [
                                    $derived_rates[$i][1], $derived_rates[$i][2]
                                ]

                            ]

                        ]


                    ];
                    array_push($optionsArray, $option);
                }

                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => null,
                        "options" => $optionsArray,
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode,
                        "children_fee" => $this->rate_type->children_fee,
                        "infant_fee" => $this->rate_type->infant_fee
                    ]

                ];
            } else if ($this->rate_type->rate_mode == "derived" && $this->rate_type->sell_mode == "per_room") {
                $data = [
                    "rate_plan" => [
                        "title" => $this->rate_type->name,
                        "property_id" => $this->hotel->active_property()->property_id,
                        "room_type_id" => $this->selected_room_type->channex_room_type_id,
                        "parent_rate_plan_id" => null,
                        "options" => [
                            [
                                "occupancy" => (int)$max_occupancy,
                                "is_primary" => true,
                                "rate" => $this->rate_type->reservation_rate
                            ]

                        ],
                        "currency" => $this->hotel->currency->initials,
                        "sell_mode" => $this->rate_type->sell_mode,
                        "rate_mode" => $this->rate_type->rate_mode

                    ]

                ];
            }
        }

        // dd(json_encode( $data));
        return $data;
    }
}
