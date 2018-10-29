<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>Список категорий</legend>
            {!! $categoriesList !!}
        </fieldset>
    </div>

    <div class="col-md-6" id="categoryFormPlaceholder">

        @include('backend.common.categories.category_form')

    </div>
</div>


