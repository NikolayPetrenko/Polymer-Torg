<fieldset>
	<legend>Поиск по сайту</legend>
	<form action="<?php echo base_url()?>main/search/" method="get" class="search-form">
		Ключевое слово: <input name="q" id="search" value="<?php echo !empty($word) ? $word : ''?>"> 
		Раздел: <select name="category">
			<option value="" <?php echo !empty($category) && $category == '' ? 'selected="selected"' : ''?>>Во всех разделах</option>
			<option value="1" <?php echo !empty($category) && $category == '1' ? 'selected="selected"' : ''?>>Полиэтилен (ПНД, ПВД)</option>
			<option value="2" <?php echo !empty($category) && $category == '2' ? 'selected="selected"' : ''?>>Полипропилен</option>
			<option value="3" <?php echo !empty($category) && $category == '3' ? 'selected="selected"' : ''?>>Отходы ПП, ПНД, ПВХ</option>
			<option value="4" <?php echo !empty($category) && $category == '4' ? 'selected="selected"' : ''?>>Прочие полимеры</option>
			<option value="5" <?php echo !empty($category) && $category == '5' ? 'selected="selected"' : ''?>>Услуги на рынке полимеров</option>
			<option value="6" <?php echo !empty($category) && $category == '6' ? 'selected="selected"' : ''?>>Экструдеры, грануляторы, дробилки</option>
			<option value="7" <?php echo !empty($category) && $category == '7' ? 'selected="selected"' : ''?>>Сварочное оборудование для полимеров</option>
			<option value="8" <?php echo !empty($category) && $category == '8' ? 'selected="selected"' : ''?>>Прочее оборудование для полимеров</option>
		</select>
		Только с фото <input type="checkbox" name="foto" value="1" <?php echo !empty($foto) && $foto == '1' ? 'checked="checked"' : ''?>>
		<input type="submit" value="Поиск">
	</form>
</fieldset>	