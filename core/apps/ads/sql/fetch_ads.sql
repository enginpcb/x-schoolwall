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

SELECT * FROM `<?php echo($data['t_ads']); ?>`
	
	WHERE `user_id` = <?php echo($data['user_id']); ?>

	AND `status` IN ('active', 'inactive')

	<?php if($data['type'] == 'active'): ?>
		AND `status` = 'active'
	<?php elseif($data['type'] == 'inactive'): ?>
		AND `status` = 'inactive'
	<?php endif; ?>

	ORDER BY `clicks` DESC, `views` DESC

<?php if($data['offset']): ?>
	LIMIT <?php echo($data['offset']); ?>, <?php echo($data['offset'] + 10); ?>;
<?php else: ?>
	LIMIT <?php echo($data['limit']); ?>;
<?php endif; ?>