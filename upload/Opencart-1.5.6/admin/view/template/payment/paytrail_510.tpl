<?php echo $header; ?>
<style>
span.help[data-toggle="tooltip"]:after {
  font-family: Verdana;
  color: #fff;
  content: "?";
  font-weight:bold;
  margin-left: 4px;
  background:#1E91CF;
  margin-left:20px;
  padding:3px;
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    > <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">

      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#paytrail-510').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
    <div class="content">

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="paytrail-510" class="form-horizontal">

     <div id="tab-general">
        <table class="form">
          <tr>
            <td style="width:20p%;"><span class="help" data-toggle="tooltip" title="<?php echo $help_merchant;?>">* <?php echo $entry_merchant; ?></span></td>
            <td style="width:80%;"><input type="text" name="paytrail_510_merchant" value="<?php echo $paytrail_510_merchant; ?>"  class="form-control"/>
              <?php if ($error_merchant) { ?>
              <span class="error"><?php echo $error_merchant; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_security;?>">* <?php echo $entry_security; ?></span></td>
            <td><input type="text" name="paytrail_510_security" value="<?php echo $paytrail_510_security; ?>"  class="form-control"/>
              <?php if ($error_security) { ?>
              <span class="error"><?php echo $error_security; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_order_status;?>">* <?php echo $entry_order_status; ?></span></td>
            <td>
            <select name="paytrail_510_order_status_id" id="select-order_status" class="form-control">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $paytrail_510_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>

              <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_cancel_status;?>">* <?php echo $entry_order_cancel_status; ?></span></td>
            <td>
            <select name="paytrail_510_order_cancel_status_id" class="form-control">
             <?php foreach ($order_statuses as $order_status) { ?>
                 <?php if ($order_status['order_status_id'] == $paytrail_510_order_cancel_status_id) { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                 <?php } else { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
             </select>
            </td>
          </tr>
          <tr>
            <td>*<?php echo $entry_geo_zone; ?></td>
            <td>
              <select name="paytrail_510_geo_zone_id" id="select-geo_zone_id" class="form-control">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
                  <?php if ($geo_zone['geo_zone_id'] == $paytrail_510_geo_zone_id) { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                  <?php } ?>
              <?php } ?>
                  </select>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_status; ?></td>
            <td>
              <select name="paytrail_510_status" id="input-status" class="form-control">
                <?php if ($paytrail_510_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_sandbox;?>"> <?php echo $entry_sandbox; ?></span></td>
            <td>
              <select name="paytrail_510_sandbox" id="input-status" class="form-control">
                <?php if ($paytrail_510_sandbox) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            
            </td>
          </tr>

              <tr>
                <td><?php echo $entry_store;?></td>
                <td>
                  <select name="paytrail_510_store_id" id="select-store" class="form-control">
              <?php foreach($stores as $store ){ ?>
                  <?php if ($store['store_id'] == $paytrail_510_geo_zone_id ){?>
                    <option value="<?php echo $store['store_id'];?>" selected="selected"><?php echo $store['name'];?></option>
                  <?php } else {?>
                    <option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>
                 <?php }
                } ?>
                  </select>
                </td>
              </tr>


              <tr>
                <td><span data-toggle="tooltip" title="<?php echo $help_font_size;?>"><?php echo $entry_paytrail_font_size;?></span></td>
                <td>
                 <input name="paytrail_510_font_size" id="input-text" value="<?php echo $paytrail_510_font_size;?>" class="form-control"/>   
                </td>
              </tr>

          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_log;?>"> <?php echo $entry_log; ?></span></td>
            <td>     
              <textarea class="form-control" rows="10"><?php echo $log; ?></textarea>
            </td>
          </tr>
          <tr>
            <td><span class="help" data-toggle="tooltip" title="<?php echo $help_failed_log;?>"> <?php echo $entry_failed_log; ?></span></td>
            <td>     
              <textarea class="form-control" rows="10"><?php echo $failed_log; ?></textarea>
            </td>
          </tr>

      </table>
    </div>


     </div>
   </div>
  </div>
</div>
<?php echo $footer; ?>