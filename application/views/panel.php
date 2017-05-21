
<?php $dane = array('id' => 'A_' . $id );
echo form_open('panel/akcja', $dane);
?>
<div class="form-inline">
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <img src="<?php echo base_url('jpg/'.$photo) ?>" alt="...">
            <div class="caption form-inline">
                <h3><?php echo $naglowek_zdjecia ?></h3>
                <p><?php echo $opis ?></p>
                <p>Cena za dobę:&nbsp;<?php echo form_input(array('name'=>'part_A_'.$id,'type'=>'text','style'=>'border:none;width:25px;display:inline','value'=>$cena))?>PLN</p>
                <p>Kaucja:&nbsp<?php echo form_input(array('name'=>'part_B_'.$id,'type'=>'text','style'=>'border:none;width:40px;display:inline','value'=>$kaucja))?> PLN</p>
                 <p><a href="<?php echo site_url('index.php/Page/A'.$id);?>" class="btn btn-primary" role="button">Wynajm</a>
                     <a  class="btn btn-default" href="<?php echo site_url('index.php/Page/B'.$id);?>" role="button">Rezerwacja</a></p>
            </div>
        </div>
    </div>
</div>
</form>

