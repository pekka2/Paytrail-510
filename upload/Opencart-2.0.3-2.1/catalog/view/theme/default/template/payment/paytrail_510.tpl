<div id="payment">

  <div style="width:100%;display:inline-block;border:solid 1px #e3e3e3;margin:5px;padding-left:2px;">

<?php
   if(!empty($providers)){
     foreach( $providers as $provider ){?>
        <div class="col-sm-3 col-xs-12" style="height:125pxpadding:13px;border:solid 1px #e3e3e3;margin-top:28px;display:block">

           <form style="display:inline" method="POST" action="<?php echo $provider->url;?>"">
            <?php foreach( $provider->parameters as $parameter ){?>
                <input type="hidden" name="<?php echo $parameter->name;?>" value="<?php echo $parameter->value;?>"/>
            <?php }?>
            <button style="width:90%;height:120px"><img style="width:94%;height:auto;" title="<?php echo $provider->name;?>" src="<?php echo $provider->icon;?>" alt="" /></button>
           </form>

         </div>
     <?php }
   }

if(!empty($error)){?>
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