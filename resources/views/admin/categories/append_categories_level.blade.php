<div class="form-group">
    <label>Choisir le niveau de la catégorie</label>
    <select name="parent_id" id="parent_id" class="form-control select2bs4" style="width: 100%;">
      <option value="0">Catégorie principale</option>
      @if (!empty($getcategories))
          @foreach ($getcategories as $category)
              <option value="">{{ $category['category_name'] }}</option>
          @endforeach
      @endif
    </select>
</div>
