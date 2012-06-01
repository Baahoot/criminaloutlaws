Hello <?php echo $to; ?>,

You're now officially a part of our PRO experience as of today, and you will receive all the benefits as of right now.

We have received your payment with <?php echo $payment_via; ?> on <?php echo unix_to_human(now()); ?> from <?php echo $payer_email; ?> (Transaction ID: <?php echo $txn; ?>) and have processed it accordingly to the username <?php echo $to; ?>.

<?php if($payment_via == 'PayPal'): ?>Your purchase is automatically recurring and you will next be charged on <?php echo unix_to_human($next_billed); ?> directly using PayPal, and it will require nothing from you as your membership on Criminal Outlaws will be updated automatically. However, to cancel your subscription, you will need to go to your PayPal account and cancel your subscription from there and it will automatically update on our system.

<?php endif; ?>If you have any concerns with your membership, or have any questions about your purchase, please do not hesitate to contact us directly at cosupport@ferple.com where we will answer you as soon as possible.

Thanks and we hope you enjoy your new membership!

Regards,
Criminal Outlaws,
cosupport@ferple.com