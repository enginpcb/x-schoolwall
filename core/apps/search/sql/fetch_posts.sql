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

SELECT * FROM `<?php echo($data['t_pubs']); ?>` 

	WHERE `status` = "active"

	<?php if(empty($cl["is_admin"])): ?>
		<?php if(not_empty($data['user_id'])): ?>
			AND (`priv_wcs` = "everyone" OR  `user_id` = <?php echo($data['user_id']); ?> OR `user_id` IN (SELECT `following_id` FROM `<?php echo($data['t_conns']); ?>` WHERE `follower_id` = <?php echo($data['user_id']); ?> AND `status` = "active"))
		<?php else: ?>
			AND `priv_wcs` = "everyone"
		<?php endif; ?>
	<?php endif; ?>

	<?php if(not_empty($data['keyword'])): ?>
		AND (`text` LIKE "%<?php echo($data['keyword']); ?>%"

		<?php if($data['htag']): ?>
			OR `text` LIKE "%{#id:<?php echo($data['htag']); ?>#}%"
		<?php endif; ?>)
	<?php endif; ?>

	<?php if(not_empty($data['offset'])): ?>
		AND `id` < <?php echo($data['offset']); ?>
	<?php endif; ?>

	<?php if(not_empty($data['user_id'])): ?>
		AND `user_id` NOT IN (SELECT b1.`profile_id` FROM `<?php echo($data['t_blocks']); ?>` b1 WHERE b1.`user_id` = <?php echo($data['user_id']); ?>)

		AND `user_id` NOT IN (SELECT b2.`user_id` FROM `<?php echo($data['t_blocks']); ?>` b2 WHERE b2.`profile_id` = <?php echo($data['user_id']); ?>)
	<?php endif; ?>

	ORDER BY `id` DESC, `likes_count` DESC, `replys_count` DESC, `reposts_count` DESC

<?php if(is_posnum($data['limit'])): ?>
	LIMIT <?php echo($data['limit']); ?>;
<?php endif; ?>

