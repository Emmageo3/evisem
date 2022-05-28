<div class="form-group">
    <label>Choisir le niveau de la catégorie</label>
    <select name="parent_id" id="parent_id" class="form-control select2bs4" style="width: 100%;">
      <option value="0" @if (isset($categorydata['parent_id']) && $categorydata['parent_id']==0) selected
      @endif>Catégorie principale</option>
      @if (!empty($getcategories))
          @foreach ($getcategories as $category)
              <option value="{{ $category['id'] }}" @if (isset($categorydata['parent_id']) && $categorydata['parent_id']==$category['id']) selected
              @endif>{{ $category['category_name'] }}</option>
              @if (!empty($category['subcategories']))
                  @foreach ($category['subcategories'] as $subcategory)
                      <option value="{{ $subcategory['id'] }}">&nbsp;&raquo;&nbsp; {{ $subcategory['category_name'] }}</option>
                  @endforeach
              @endif
          @endforeach
      @endif
    </select>
</div>
