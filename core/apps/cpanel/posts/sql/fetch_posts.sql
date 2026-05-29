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

SELECT * FROM `<?php echo($data['t_pubs']) ?>`
	
	WHERE `status` = 'active'

	<?php if($data['offset']): ?>

		<?php if($data['offset_to'] == 'gt'): ?>

			AND `id` > <?php echo($data['offset']) ?>

		<?php else: ?>

			AND `id` < <?php echo($data['offset']) ?>

		<?php endif; ?>	

	<?php endif; ?>

	<?php if($data['keyword']): ?>

		AND `text` LIKE '%<?php echo($data["keyword"]) ?>%'

	<?php endif; ?>

	ORDER BY `id` <?php echo($data['order']) ?> 

<?php if($data['limit']): ?>

	LIMIT <?php echo($data['limit']) ?>
	
<?php endif; ?>