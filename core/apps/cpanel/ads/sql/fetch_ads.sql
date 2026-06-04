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

SELECT a.`id`, a.`user_id`, a.`cover`, a.`target_url`, a.`views`, a.`clicks`, a.`budget`, a.`time`, a.`status`, u.`avatar`, u.`username`, u.`verified`, CONCAT(u.`fname`, ' ', u.`lname`) AS name FROM `<?php echo($data['t_ads']); ?>` a
	
	INNER JOIN `<?php echo($data['t_users']); ?>` u ON a.`user_id` = u.`id`

	WHERE a.`status` != 'orphan'

	AND u.`active` = '1'

	<?php if($data['offset']): ?>
		<?php if($data['offset_to'] == 'gt'): ?>
			AND a.`id` > <?php echo($data['offset']) ?>
		<?php else: ?>
			AND a.`id` < <?php echo($data['offset']) ?>
		<?php endif; ?>	
	<?php endif; ?>

ORDER BY a.`id` <?php echo($data['order']) ?> LIMIT <?php echo($data['limit']) ?>;
