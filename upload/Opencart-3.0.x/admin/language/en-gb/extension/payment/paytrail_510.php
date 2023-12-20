<?php
// Heading
$_['heading_title']          = 'Paytrail 5.10';

// Text 
$_['text_edit']              = 'Edit Paytrail';
$_['text_payment']           = 'Payment method';
$_['text_success']           = 'Paytrail payment method modification has been successfull!';
$_['text_paytrail_510']     = '<a target="_BLANK" href="https://www.paytrail.com/"><img src="view/image/payment/paytrail.png" alt="Paytrail Website" title="Paytrail Website" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_clear_success']     = 'Erasing of log files has been successffull!';
$_['text_extension']         = 'Extensions';
      
// Entry
$_['entry_merchant']            = 'Merchant Identification';
$_['entry_security']            = 'Secret key';
$_['entry_order_status']        = 'Order status';
$_['entry_order_cancel_status'] = 'Cancelled order status:';
$_['entry_geo_zone']            = 'Geo zone:';
$_['entry_status']              = 'Status';
$_['entry_sort_order']          = 'Order';
$_['entry_sandbox']             = 'Testmode';
$_['entry_paytrail_font_size']  = '\'Web Payment\' text size in pixels';
$_['entry_log']                 = 'Log';
$_['entry_failed_log']          = 'Log 2';
$_['entry_store']               = 'Store';

// Placeholder
$_['placeholder_merchant']      = 'Set Merchant ID';
$_['placeholder_security']      = 'Set the Secret Key';

// Error
$_['error_permission']   = 'Warning: You do not have the rights to modify Paytrail 5.10 payment method!';
$_['error_merchant']     = 'Merchant identification is a required information!';
$_['error_security']     = 'Secret key is a required information!';

// Help
$_['help_merchant']      = 'Merchant identification ie merchant ID, which has been provided to you by Paytrail.';
$_['help_security']      = 'Secret Key, which has been provided to you by Paytrail 5.10.';
$_['help_order_status']  = 'Successful order status, when client returns back to store after payment from the bank page.';
$_['help_cancel_status'] = 'Failed order status, when client returns back to store after payment from the bank page (either cancels payment himself or payment has been cancelled for some other reason).';
$_['help_geo_zone']      = 'Select the geo zone here, where your web shop has sales.';
$_['help_sandbox']       = 'You can test this extension functionality. When you use testmode \'Merchant identification\' and \'Secret key\' are not required information.';
$_['help_font_size']     = 'Text \'Web Payment\' size in pixels (insert just numbers!)';
$_['help_log']          = 'Log file, which contains all traffic from successful and failed payment transactions.';
$_['help_failed_log']   = 'Log file, which contain payment tranactions which had failed from some reason or payment transactions which had been independly cancelled by the customer.';
?>
