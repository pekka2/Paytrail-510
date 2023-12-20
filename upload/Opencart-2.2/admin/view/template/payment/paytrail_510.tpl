<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-bank-transfer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $clear;?>" data-toggle="tooltip" title="<?php echo $button_clear;?>" class="btn btn-danger"><i class="fa fa-eraser"></i></a>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bank-transfer" class="form-horizontal">
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-merchant"><span data-toggle="tooltip" title="<?php echo $help_merchant;?>"><?php echo $entry_merchant; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="paytrail_510_merchant" value="<?php echo $paytrail_510_merchant; ?>" placeholder="<?php echo $entry_merchant; ?>" id="input-merchant" class="form-control" />
                  <?php if ($error_merchant) { ?>
                  <div class="text-danger"><?php echo $error_merchant; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-security"><span data-toggle="tooltip" title="<?php echo $help_security;?>"><?php echo $entry_security; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="paytrail_510_security" value="<?php echo $paytrail_510_security; ?>" placeholder="<?php echo $entry_security; ?>" id="input-security" class="form-control" />
                  <?php if ($error_security) { ?>
                  <div class="text-danger"><?php echo $error_security; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="select-order_status"><span data-toggle="tooltip" title="<?php echo $help_order_status;?>"><?php echo $entry_order_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="paytrail_510_order_status_id" id="select-order_status" class="form-control">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $paytrail_510_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>

              <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="select-order_status"><span data-toggle="tooltip" title="<?php echo $help_cancel_status;?>"><?php echo $entry_order_cancel_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="paytrail_510_order_cancel_status_id" id="select-order_status" class="form-control">
                 <?php foreach ($order_statuses as $order_status) { ?>
                 <?php if ($order_status['order_status_id'] == $paytrail_510_order_cancel_status_id) { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                 <?php } else { ?>
                 <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
              <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="select-geo_zone_id"><span data-toggle="tooltip" title="<?php echo $help_geo_zone;?>"><?php echo $entry_geo_zone; ?></span></label>
                <div class="col-sm-10">
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
                </div>
              </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="paytrail_510_status" id="input-status" class="form-control">
                <?php if ($paytrail_510_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $help_sandbox;?>"><?php echo $entry_sandbox; ?></span></label>
            <div class="col-sm-10">
              <select name="paytrail_510_sandbox" id="input-status" class="form-control">
                <?php if ($paytrail_510_sandbox) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="select-geo_zone_id"><?php echo $entry_store;?></label>
                <div class="col-sm-10">
                  <select name="paytrail_510_store_id" id="select-store" class="form-control">
              <?php foreach($stores as $store ){ ?>
                  <?php if ($store['store_id'] == $paytrail_510_geo_zone_id ){?>
                    <option value="<?php echo $store['store_id'];?>" selected="selected"><?php echo $store['name'];?></option>
                  <?php } else {?>
                    <option value="<?php echo $store['store_id'];?>"><?php echo $store['name'];?></option>
                 <?php }
                } ?>
                  </select>
                </div>
              </div>
              

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-text"><span data-toggle="tooltip" title="<?php echo $help_font_size;?>"><?php echo $entry_paytrail_font_size;?></span></label>
                <div class="col-sm-5">
                 <input name="paytrail_510_font_size" id="input-text" value="<?php echo $paytrail_510_font_size;?>" class="form-control"/>   
                </div>
              </div>
      <div class="form-group">
      <label class="col-sm-2 control-label" for="input-sort-order"><span data-toggle="tooltip" title="<?php echo $help_log;?>"><?php echo $entry_log; ?></span></label>
      <div class="col-sm-10">
       <textarea class="form-control" rows="10"><?php echo $log; ?></textarea>
      </div>
     </div>
      <div class="form-group">
      <label class="col-sm-2 control-label" for="input-sort-order"><span data-toggle="tooltip" title="<?php echo $help_failed_log;?>"><?php echo $entry_failed_log; ?></span></label>
      <div class="col-sm-10">
       <textarea class="form-control" rows="10"><?php echo $failed_log; ?></textarea>
   </div>
     </div>
 </div>

    </form>

     </div>
   </div>
  </div>
</div>

<?php echo $footer; ?>