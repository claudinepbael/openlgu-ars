<style><?php echo file_get_contents(Yii::getPathOfAlias('webroot.css').'/worksheet.css') ?></style>
<div class="worksheet">
    <table>
                <tr> <td colspan="12" id="borderless"> <b> LGU MENDEZ  </b>  </td> </tr>
                <tr> <td colspan="12" id="borderless"> <b> Worksheet   </b>  </td> </tr>
                <tr>
                    <td colspan="12" id="borderless">
                         <b>
                            as of
                         <?php 
                            if(isset($_POST['month_to_generate']))
                                echo $daterange[$_POST['month_to_generate']] ." " .$_POST['year_to_generate'];
                            //possible pang mabago, as of Annual kasi yung nakalagay
                         ?>
                         </b>
                    </td>
                </tr>
                <tr> <td id="borderless"> </td> </tr>
                <tr><td id="borderless"></td></tr>
                <tr height="70px"> 
                        <td colspan="2"> Accounts </td> 
                        <td colspan="2"> Trial Balance </td> 
                        <td colspan="2"> Adjustments </td> 
                        <td colspan="2"> Adjusted Trial Balance </td> 
                        <td colspan="2"> Statement of Income & Expenses </td> 
                        <td colspan="2"> Balance Sheet </td> 
                </tr>
                <tr height="30px"> 
                        <td> Title </td> 
                        <td> Code </td> 
                        <td> Dr </td> 
                        <td> Cr </td> 
                        <td> Dr </td> 
                        <td> Cr </td>
                        <td> Dr </td> 
                        <td> Cr </td> 
                        <td> Dr </td> 
                        <td> Cr </td>
                        <td> Dr </td> 
                        <td> Cr </td> 
                </tr>
            <?php 
                if(isset($worksheet)){
                    // var_dump($worksheet);
                    foreach($worksheet as $key => $item){
            ?>      
                    <tr>
                        <td id="acct_title">
                           <b> <?php echo $item['title'];?> </b>
                        </td>
                        <td>
                            <?php echo $key;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['tb_debit']>0)echo $item['tb_debit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['tb_credit']>0)echo $item['tb_credit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['adj_debit']>0)echo $item['adj_debit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['adj_credit']>0)echo $item['adj_credit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['adj_tb_debit']>0)echo $item['adj_tb_debit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['adj_tb_credit']>0)echo $item['adj_tb_credit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['is_debit']>0)echo $item['is_debit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['is_credit']>0)echo $item['is_credit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['bs_debit']>0)echo $item['bs_debit'] ;?>
                        </td>
                        <td id="drcr">
                            <?php if($item['bs_credit']>0)echo $item['bs_credit'] ;?>
                        </td>
                    </tr>  
                
             <?php } ?>

                <tr>
                        <td            ><?php echo "<b>Total</b>" ?></td>
                        <td            ></td>
                        <td id="total"><?php echo $total['tb_debit'];?></td>
                        <td id="total"><?php echo $total['tb_credit'];?></td>
                        <td id="total"><?php echo $total['adj_debit'];?></td>
                        <td id="total"><?php echo $total['adj_credit'];?></td>
                        <td id="total"><?php echo $total['adj_tb_debit'];?></td>
                        <td id="total"><?php echo $total['adj_tb_credit'];?></td>
                        <td id="total"><?php echo $total['is_debit'];?></td>
                        <td id="total"><?php echo $total['is_credit'];?></td>
                        <td id="total"><?php echo $total['bs_debit'];?></td>
                        <td id="total"><?php echo $total['bs_credit'];?></td>
                </tr> 
                <tr>
                        <td><b>Net
                            <?php 
                                if($total['is_net_profit'] > 0){
                                    echo"Income</b>";
                                }else{
                                    echo"Loss</b>";
                                }
                            ?>
                        </td>                    
                        <td>                     </td>
                        <td>                     </td>
                        <td>                     </td>
                        <td>                     </td>
                        <td>                     </td>
                        <td>                     </td>
                        <td>                     </td>
                        <td id="total"><?php if( $total['is_net_profit'] > 0 ) echo $total['is_net_profit']; ?></td>                
                        <td id="total"><?php if( $total['is_net_loss'] > 0 ) echo $total['is_net_loss']; ?></td>
                        <td id="total"><?php if( $total['bs_net_profit'] > 0 ) echo $total['bs_net_profit']; ?></td>
                        <td id="total"><?php if( $total['bs_net_loss'] > 0 ) echo $total['bs_net_loss']; ?></td>
                </tr> 

                <tr>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="borderless">                     </td>
                        <td id="total"><?php echo $total['is_bal_dr']; ?></td>                
                        <td id="total"><?php echo $total['is_bal_cr']; ?></td>
                        <td id="total"><?php echo $total['bs_bal_dr']; ?></td>
                        <td id="total"><?php echo $total['bs_bal_cr']; ?></td>
                </tr> 

            <?php } ?>

        </table>
        <br/>
        <table class="signature">
            <tr>    <td>          </td>      </tr>
            <tr>    <td>_________________________</td>      </tr>
            <tr>    <td>NAME NAME NAME</td>      </tr>
            <tr>    <td>ACCOUNTANT</td>      </tr>
            <tr>    <td>          </td>      </tr>
            <tr>    <td>__________________________</td>      </tr>
            <tr>    <td>DATE SIGNED</td>      </tr>
        </table>

        <p class="timestamp">
            Generated by: ASFDFASHDGASJ as of 
            <?php
                date_default_timezone_set('Asia/Manila');
                echo date("M d, Y g:i A");?> 
        </p>
</div>