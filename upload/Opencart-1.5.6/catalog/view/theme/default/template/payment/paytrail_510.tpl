<div id="payment">

  <div style="width:100%;display:inline-block;border:solid 1px #e3e3e3;margin:2px;padding-left:10px;">

  <div class="box-content">
    <div class="box-product">
<?php
   if($providers){
     foreach( $providers as $provider ){?>
        <div style="padding:5px">
           <form style="display:inline" method="POST" action="<?php echo $provider->url;?>"">
            <?php foreach( $provider->parameters as $parameter ){?>
                <input type="hidden" name="<?php echo $parameter->name;?>" value="<?php echo $parameter->value;?>"/>
            <?php }?>
            <button style="width:90%;height:90%;"><img style="width:94%;height:auto;" title="<?php echo $provider->name;?>" src="<?php echo $provider->icon;?>" alt="" /></button>
           </form>

         </div>
     <?php }
   }?>

    </div>
  </div>
<?php if($error){?>
    <pre>
      <?php  echo $error; ?>
    </pre>
<?php }?>

</div>

<div class="buttons">
  <div class="pull-left">
        <a href="<?php echo $back;?>" data-toggle="tooltip" title="<?php echo $button_back;?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
  </div>
</div>

</div>