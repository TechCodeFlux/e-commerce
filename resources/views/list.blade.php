  
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<h2>hi all welcome to my simple page</h2>

<select class="js-example-basic-multiple" name="states[]" multiple="multiple">
  <option value="AL">Alabama</option>
  <option value="ww">wwwww</option> 
  <option value="WY">Wyoming</option>
</select>

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
