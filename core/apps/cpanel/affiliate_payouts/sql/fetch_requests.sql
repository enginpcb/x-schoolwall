/*
@*************************************************************************@
@ @author 松果商城									  @
@ @author_url 1: https://www.pineal.cn/                      @
@ @author_url 2: https://www.pineal.cn/goods/lists                     @
@ @author_email: 18581281315@163l.com                                @
@*************************************************************************@
@ 松果商城- The Ultimate Modern Social Media Sharing Platform           @
@ Copyright (c) 21.05.2021 松果商城All rights reserved.                @
@*************************************************************************@
 */

SELECT r.`id`, r.`email` AS paypal, r.`amount`, r.`status`, r.`time`,  u.`email`, u.`avatar`, u.`email`, u.`verified`, u.`username`, CONCAT(u.`fname`, ' ', u.`lname`) AS name FROM `<?php echo($data['t_reqs']) ?>` r

	INNER JOIN `<?php echo($data['t_users']); ?>` u ON r.`user_id` = u.`id`

	WHERE u.`active` IN ('1', '2')

	AND r.`status` = 'pending'

	<?php if($data['offset']): ?>

		<?php if($data['offset_to'] == 'gt'): ?>

			AND r.`id` > <?php echo($data['offset']) ?>

		<?php else: ?>

			AND r.`id` < <?php echo($data['offset']) ?>

		<?php endif; ?>	

	<?php endif; ?>

	ORDER BY r.`id` <?php echo($data['order']) ?> 

<?php if($data['limit']): ?>	
	LIMIT <?php echo($data['limit']) ?>;
<?php endif; ?>