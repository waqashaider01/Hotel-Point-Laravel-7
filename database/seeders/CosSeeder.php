<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CostOfSale;
use App\Models\Description;
use App\Models\HotelSetting;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class CosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel = HotelSetting::first();
        if(!$hotel){
            return;
        }

        Supplier::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_supplier_1',
            'tax_number' => '1234',
            'address' => 'asdf',
            'category' => 'idk',
            'email' => 'test@gmail.com',
            'phone' => '12345123',
        ]);
        Supplier::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_supplier_2',
            'tax_number' => '1234',
            'address' => 'asdf',
            'category' => 'idk',
            'email' => 'test@gmail.com',
            'phone' => '12345123',
        ]);
        Supplier::create([
            'hotel_settings_id' => $hotel->id,
            'name' => 'test_supplier_3',
            'tax_number' => '1234',
            'address' => 'asdf',
            'category' => 'idk',
            'email' => 'test@gmail.com',
            'phone' => '12345123',
        ]);

        $cos1 = CostOfSale::create([
            'id'=>1,
            'name' => 'Rooms Department'
        ]);
        $cos2 = CostOfSale::create([
            'id'=>2,
            'name' => 'F & B Department'
        ]);
        $cos3 = CostOfSale::create([
            'id'=>3,
            'name' => 'Other Operating department'
        ]);
        $cos4 = CostOfSale::create([
            'id'=>4,
            'name' => 'Administration and General Department'
        ]);
        $cos5 = CostOfSale::create([
            'id'=>5,
            'name' => 'Sales and Marketing Department'
        ]);
        $cos6 = CostOfSale::create([
            'id'=>6,
            'name' => 'Repairs-Maintenance and Energy Cost'
        ]);
        $cos7 = CostOfSale::create([
            'id'=>7,
            'name' => 'Basic Management Fees'
        ]);
        $cos8 = CostOfSale::create([
            'id'=>8,
            'name' => 'Non-Operating Items'
        ]);
        $cos9 = CostOfSale::create([
            'id'=>9,
            'name' => 'Fixed Charges'
        ]);
        $cat1 = Category::create([
            'id'=>1,
            'name' => 'Operating Expense',
            'cost_of_sale_id' => $cos1->id,
        ]);
        $cat2 = Category::create([
            'id'=>2,
            'name' => 'Operating Expense',
            'cost_of_sale_id' => $cos2->id,
        ]);
        $cat3 = Category::create([
            'id'=>3,
            'name' => 'Cost Of Sales',
            'cost_of_sale_id' => $cos2->id,
        ]);
        $cat4 = Category::create([
            'id'=>4,
            'name' => 'Spa Operating Expenses',
            'cost_of_sale_id' => $cos3->id,
        ]);
        $cat5 = Category::create([
            'id'=>5,
            'name' => 'Other Income Expenses',
            'cost_of_sale_id' => $cos3->id,
        ]);
        $cat6 = Category::create([
            'id'=>6,
            'name' => 'A&G Operating Expenses',
            'cost_of_sale_id' => $cos4->id,
        ]);
        $cat7 = Category::create([
            'id'=>7,
            'name' => 'Sales Operating Expenses',
            'cost_of_sale_id' => $cos5->id,
        ]);
        $cat8 = Category::create([
            'id'=>8,
            'name' => 'Marketing Operating Expenses',
            'cost_of_sale_id' => $cos5->id,
        ]);
        $cat9 = Category::create([
            'id'=>9,
            'name' => 'R&M Operating Expenses',
            'cost_of_sale_id' => $cos6->id,
        ]);
        $cat10 = Category::create([
            'id'=>10,
            'name' => 'Energy Costs',
            'cost_of_sale_id' => $cos6->id,
        ]);
        $cat11 = Category::create([
            'id'=>11,
            'name' => 'Basic Management Fees',
            'cost_of_sale_id' => $cos7->id,
        ]);
        $cat12 = Category::create([
            'id'=>12,
            'name' => 'Non Operating Items',
            'cost_of_sale_id' => $cos8->id,
        ]);
        $cat13 = Category::create([
            'id'=>13,
            'name' => 'Fixed Charges',
            'cost_of_sale_id' => $cos9->id,
        ]);

        // category 1
        Description::create([
            'id'=>1,
            'name' => 'Guest amenities & supplies',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>2,
            'name' => 'Cleaning materials & consumables',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>3,
            'name' => 'Outside laundry & dry cleaning',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>4,
            'name' => 'Contract cleaning',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>5,
            'name' => 'Staff uniforms',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>6,
            'name' => 'Flowers & decorations',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>7,
            'name' => 'Travel agent commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>8,
            'name' => 'Tour operators commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>9,
            'name' => 'IDS commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>10,
            'name' => 'Affiliation commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>11,
            'name' => 'Newspapers & Magazines',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>12,
            'name' => 'Equipment replacement',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>13,
            'name' => 'Staff travel expenses & training',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>14,
            'name' => 'Miscellaneous',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>15,
            'name' => 'Own web site commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>16,
            'name' => 'Home / villa OTAs commissions',
            'category_id' => $cat1->id,
        ]);
        Description::create([
            'id'=>17,
            'name' => 'Complimentary',
            'category_id' => $cat1->id,
        ]);
    //    category 3
        Description::create([
            'id'=>18,
            'name' => 'Food cost',
            'category_id' => $cat3->id,
        ]);
        Description::create([
            'id'=>19,
            'name' => 'Beverage cost',
            'category_id' => $cat3->id,
        ]);
        Description::create([
            'id'=>20,
            'name' => 'Other cost of sales',
            'category_id' => $cat3->id,
        ]);

        // category 2
        Description::create([
            'id'=>21,
            'name' => 'Outside laundry & dry cleaning',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>22,
            'name' => 'Staff uniforms',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>23,
            'name' => 'Staff travel expenses & training',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>24,
            'name' => 'Kitchen supplies & cleaning materials',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>25,
            'name' => 'Rest./Bar Supplies & cleaning materials',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>26,
            'name' => 'Kitchen equipment replacement',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>27,
            'name' => 'Rest./Bar equipment replacement',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>28,
            'name' => 'Flowers & decorations',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>29,
            'name' => 'Contract cleaning',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>30,
            'name' => 'Music & entertainment',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>31,
            'name' => 'Miscellaneous',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>32,
            'name' => 'Other rents (equipment rent)',
            'category_id' => $cat2->id,
        ]);
        Description::create([
            'id'=>33,
            'name' => 'Complimentary',
            'category_id' => $cat2->id,
        ]);

        // category 4
        Description::create([
            'id'=>34,
            'name' => 'Spa products',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>35,
            'name' => 'Spa amenities & consumables',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>36,
            'name' => 'Cleaning materials',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>37,
            'name' => 'Outside laundry Dry cleaning',
            'category_id' => $cat4->id,
        ]);

        Description::create([
            'id'=>38,
            'name' => 'Staff uniforms',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>39,
            'name' => 'External therapists fees',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>40,
            'name' => 'Flowers & Decorations',
            'category_id' => $cat4->id,
        ]);

        Description::create([
            'id'=>41,
            'name' => 'Contract Cleaning',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>42,
            'name' => 'Equipment replacement',
            'category_id' => $cat4->id,
        ]);
        Description::create([
            'id'=>43,
            'name' => 'Miscellaneous',
            'category_id' => $cat4->id,
        ]);

        // category 5
        Description::create([
            'id'=>44,
            'name' => 'Outside laundry & dry cleaning',
            'category_id' => $cat5->id,
        ]);
        Description::create([
            'id'=>45,
            'name' => 'Guest transfers cost',
            'category_id' => $cat5->id,
        ]);
        Description::create([
            'id'=>46,
            'name' => 'Excursion costs',
            'category_id' => $cat5->id,
        ]);
        Description::create([
            'id'=>47,
            'name' => 'Cigars',
            'category_id' => $cat5->id,
        ]);
        Description::create([
            'id'=>48,
            'name' => 'Guest Sundries / Souven./Newspapers',
            'category_id' => $cat5->id,
        ]);
        Description::create([
            'id'=>49,
            'name' => 'Miscellaneous',
            'category_id' => $cat5->id,
        ]);

        // category 6
        Description::create([
            'id'=>50,
            'name' => 'Credit card commissions',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>51,
            'name' => 'Telephones Costs (OTE) & mobiles',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>52,
            'name' => 'Bank charges & exchange difference',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>53,
            'name' => 'Postage & Courier',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>54,
            'name' => 'Printing & stationery',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>55,
            'name' => 'Travel expenses',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>56,
            'name' => 'Information tech & system costs',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>57,
            'name' => 'Tax - legal & professional services',
            'category_id' => $cat6->id,
        ]);

        Description::create([
            'id'=>58,
            'name' => 'Subscriptions & Chambers costs',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>59,
            'name' => 'Licences & Permits',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>60,
            'name' => 'Staff recruitment & training',
            'category_id' => $cat6->id,
        ]);

        Description::create([
            'id'=>61,
            'name' => 'Transportation costs',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>62,
            'name' => 'Miscellaneous',
            'category_id' => $cat6->id,
        ]);
        Description::create([
            'id'=>63,
            'name' => 'Other Rents (personnel Houses)',
            'category_id' => $cat6->id,
        ]);

        // category 7
        Description::create([
            'id'=>64,
            'name' => 'Travel & Subsistence',
            'category_id' => $cat7->id,
        ]);
        Description::create([
            'id'=>65,
            'name' => 'External Entertainment',
            'category_id' => $cat7->id,
        ]);
        Description::create([
            'id'=>66,
            'name' => 'Complimentary Rooms / House checks',
            'category_id' => $cat7->id,
        ]);
        Description::create([
            'id'=>67,
            'name' => 'Trade shows participation',
            'category_id' => $cat7->id,
        ]);
        Description::create([
            'id'=>68,
            'name' => 'Training',
            'category_id' => $cat7->id,
        ]);
        Description::create([
            'id'=>69,
            'name' => 'Other sales expenses',
            'category_id' => $cat7->id,
        ]);

        // category 8
        Description::create([
            'id'=>70,
            'name' => 'Advertising - magazines',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>71,
            'name' => 'Advertising - Guides & TO brochures',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>72,
            'name' => 'Advertising - GDS',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>73,
            'name' => 'Advertising - Internet',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>74,
            'name' => 'Brochures',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>75,
            'name' => 'Promotional & Collateral Material',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>76,
            'name' => 'Web site fees',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>77,
            'name' => 'Affiliation marketing fees',
            'category_id' => $cat8->id,
        ]);

        Description::create([
            'id'=>78,
            'name' => 'Public relations',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>79,
            'name' => 'Photography',
            'category_id' => $cat8->id,
        ]);
        Description::create([
            'id'=>80,
            'name' => 'Direct mail',
            'category_id' => $cat8->id,
        ]);

        Description::create([
            'id'=>81,
            'name' => 'Other marketing expense',
            'category_id' => $cat8->id,
        ]);
        // category 9
        Description::create([
            'id'=>82,
            'name' => 'Maintenance contracts',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>83,
            'name' => 'FF&E replacement',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>84,
            'name' => 'Painting & decorating',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>85,
            'name' => 'Carpentry',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>86,
            'name' => 'Electrical & Lighting',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>87,
            'name' => 'Plumbing',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>88,
            'name' => 'Heating & air-conditioning',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>89,
            'name' => 'Tools & consumables',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>90,
            'name' => 'Pest control',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>91,
            'name' => 'Health / Hygiene & safety',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>92,
            'name' => 'Fire precautions',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>93,
            'name' => 'Plants & landscaping',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>94,
            'name' => 'Waste removal',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>95,
            'name' => 'Storage',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>96,
            'name' => 'Engineering & design',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>97,
            'name' => 'Lift maintenance',
            'category_id' => $cat9->id,
        ]);

        Description::create([
            'id'=>98,
            'name' => 'Other R&M costs',
            'category_id' => $cat9->id,
        ]);
        Description::create([
            'id'=>99,
            'name' => 'FF&E repairs',
            'category_id' => $cat9->id,
        ]);

        // categoryy 10
        Description::create([
            'id'=>100,
            'name' => 'Electrical supply (EH)',
            'category_id' => $cat10->id,
        ]);
        Description::create([
            'id'=>101,
            'name' => 'Water supply & drainage',
            'category_id' => $cat10->id,
        ]);
        Description::create([
            'id'=>102,
            'name' => 'Gas',
            'category_id' => $cat10->id,
        ]);
        Description::create([
            'id'=>103,
            'name' => 'Vehicles gas / diesel',
            'category_id' => $cat10->id,
        ]);
        Description::create([
            'id'=>104,
            'name' => 'Petroleum',
            'category_id' => $cat10->id,
        ]);
        Description::create([
            'id'=>105,
            'name' => 'Other energy costs',
            'category_id' => $cat10->id,
        ]);

        // category 11
        Description::create([
            'id'=>106,
            'name' => 'Management Fee (on revenue)',
            'category_id' => $cat11->id,
        ]);
        Description::create([
            'id'=>107,
            'name' => 'Fixed management fee',
            'category_id' => $cat11->id,
        ]);

        // category 12
        Description::create([
            'id'=>108,
            'name' => 'Non operating expenses (OB)',
            'category_id' => $cat12->id,
        ]);
        Description::create([
            'id'=>109,
            'name' => 'Extraordinary expenses',
            'category_id' => $cat12->id,
        ]);
        Description::create([
            'id'=>110,
            'name' => 'Prior year expenses',
            'category_id' => $cat12->id,
        ]);

        // category 13
        Description::create([
            'id'=>111,
            'name' => 'Rent',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>112,
            'name' => 'Insurance',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>113,
            'name' => 'Taxes & Levies',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>114,
            'name' => 'Stamp Duty',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>115,
            'name' => 'Circulation Taxes',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>116,
            'name' => 'VAT',
            'category_id' => $cat13->id,
        ]);
        Description::create([
            'id'=>117,
            'name' => 'Other Taxes',
            'category_id' => $cat13->id,
        ]);
    }
}
