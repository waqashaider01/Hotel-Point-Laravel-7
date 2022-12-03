@extends('layouts.master')

@push('styles')
    <style>
        .meal-icon-rounded {
            margin-left: 50%;
            transform: translateX(-50%);
            margin-top: -8%;
            font-size: 30px;
            background-color: #48BBBE;
            border: 5px solid #F5F7F9;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

    </style>
@endpush
@section('content')
    @livewire('rate-type-categories.rate-type-categories')
@endsection

@push('scripts')
    <script>
        // var minpositionacc = document.getElementById('minpositionacc').innerHTML;
        // var lastpositionacc = document.getElementById('lastpositionacc').innerHTML;
        // var maxpositionacc = document.getElementById('maxpositionacc').innerHTML;
        // if (minpositionacc == '1') {

        //     document.getElementById('pbtnacc').classList.remove('text-dark');
        // } else {

        //     document.getElementById('pbtnacc').classList.add('text-dark');
        // }
        // if (lastpositionacc == maxpositionacc) {
        //     document.getElementById('nbtnacc').classList.remove('text-dark');
        // } else {
        //     document.getElementById('nbtnacc').classList.add('text-dark');
        // }

        function backfunctionacc() {
            //alert('previous');
            var lastposition = document.getElementById('minpositionacc').innerHTML;
            lastposition = parseInt(lastposition);
            lastposition = lastposition - 10;
            if (lastposition >= 1) {
                location.replace("meal_categories?rownoacc=" + lastposition);
            } else {}
            //alert('previous'+lastposition);
        }

        function nextfunctionacc() {
            var lastposition = document.getElementById('lastpositionacc').innerHTML;
            var maxposition = document.getElementById('maxpositionacc').innerHTML;
            lastposition = parseInt(lastposition);
            maxposition = parseInt(maxposition);
            lastposition = lastposition + 1;
            //alert('next'+lastposition);
            if (lastposition <= maxposition) {
                location.replace("meal_categories?rownoacc=" + lastposition);
            } else {}

        }




        function editcat(id) {
            var mealCategoryId = id;
            //alert(id);
            $.ajax({
                url: "/meal-category/"+mealCategoryId,
                method: "get",

                success: function(data) {
                    $('#editMealCategoryModalBody').html(data);
                    $('#editMealCategoryModal').modal('show');
                }
            });
        }
        $(document).ready(function() {
            $('.editBtn1').on('click', function() {

                var mealCategoryId = $(this).attr("id");

                $.ajax({
                    url: "/meal-category/"+mealCategoryId,
                    method: "put",

                    success: function(data) {
                        $('#editMealCategoryModalBody').html(data);
                        $('#editMealCategoryModal').modal('show');
                    }
                });

            });
        });
    </script>
@endpush
