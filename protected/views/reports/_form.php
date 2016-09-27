<div class="form report_form" style="display:inline-block">
  <form action="#" method="POST">
   <?php 
        $month_to_generate = isset($_POST['month_to_generate']) ? $_POST['month_to_generate'] : '01';

        echo CHtml::dropDownList('month_to_generate',$month_to_generate , $daterange);

        $year = isset($_POST['year_to_generate']) ? $_POST['year_to_generate'] : $yearNow;

        echo "<input name='year_to_generate' ";
        echo "value='{$year}' type='number' min='{$yearFrom}' ";
        echo "max='{$yearNow}' style='margin-left:5px'/>";

        echo CHtml::submitButton('Generate',array('class'=>'ars_btn'));
   ?>
  </form>
</div>