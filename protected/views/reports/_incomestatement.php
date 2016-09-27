 <div class="worksheet">
    <table id='balanceSheet'>
        <tr> <td colspan="12" class="borderless is_title"> <b> LGU MENDEZ  </b>  </td> </tr>
        <tr> <td colspan="12" class="borderless is_title"> <b> Income Statement   </b>  </td> </tr>
        <tr>
            <td colspan="12" class="borderless is_title">
                 <b>
                    <?php 
                        if(isset($for)) echo $for;
                    //possible pang mabago, as of Annual kasi yung nakalagay
                    ?>
                 </b>
            </td>
        </tr>
        <tr>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
            <td class="spacer_column"></td>
        </tr>
        
        <?php
            foreach ($view_data as $key => $value) {
                echo $value;
            }
        ?>

    </table>

    <br/>

    <table class="signature">
        <tr>    <td class="spacer_column"></td>      </tr>
        <tr>    <td>_________________________</td>      </tr>
        <tr>    <td><?php echo LGUAccountant::model()->findByPk(1)->getAttribute('accountant_name')?></td>      </tr>
        <tr>    <td>ACCOUNTANT</td>      </tr>
        <tr>    <td class="spacer_column"></td>      </tr>
        <tr>    <td>__________________________</td>      </tr>
        <tr>    <td>DATE SIGNED</td>      </tr>
    </table>

    <p class="timestamp">
        
    </p>
</div>
