Hello <?php echo (defined('TO') ? TO : 'null'); ?>,

You have requested to reset your password from the account you have registered on CriminalOutlaws.com.

To reset your password please click the following link below:
<a href="<?php echo RESET_URL; ?>" target="_blank"><?php echo RESET_URL; ?></a>

The request will expire at <?php echo unix_to_human(RESET_EXPIRES); ?> and must be accessed from the same IP address that made the request which is stated below.

The request was made from the IP address <?php echo $this->input->ip_address(); ?> at <?php echo unix_to_human(now()); ?>. If you believe the request was made in error, please ignore this e-mail and if you are gaining concerns from these requests then please contact our support at cosupport@ferple.com and we will sort your request accordingly.

Regards,
Criminal Outlaws,
cosupport@ferple.com