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

SELECT `id`, `email`, `active`, `avatar`, `active`, `verified`, `last_active`, `username`, `country_id`, `ip_address`, CONCAT(`fname`,' ', `lname`) as `name`

	FROM `<?php echo($data['t_users']); ?>`

	WHERE `id` > 0

	AND `active` IN ("1", "2")

	<?php if($data['offset']): ?>

		<?php if($data['offset_to'] == 'gt'): ?>

			AND `id` > <?php echo($data['offset']); ?>

		<?php else: ?>

			AND `id` < <?php echo($data['offset']); ?>

		<?php endif; ?>	

	<?php endif; ?>

	<?php if(not_empty($data['filter'])): ?>
		<?php if(not_empty($data['filter']['username'])): ?>
			AND (`fname` LIKE "%<?php echo cl_text_secure($data['filter']['username']); ?>%" OR `lname` LIKE "%<?php echo cl_text_secure($data['filter']['username']); ?>%" OR `username` LIKE "%<?php echo cl_text_secure($data['filter']['username']); ?>%")
		<?php endif; ?>

		<?php if(is_posnum($data['filter']['country'])): ?>
			AND `country_id` = <?php echo($data['filter']['country']); ?>
		<?php endif; ?>

		<?php if(not_empty($data['filter']['ip'])): ?>
			AND `ip_address` = "<?php echo cl_text_secure($data['filter']['ip']); ?>"
		<?php endif; ?>

		<?php if(not_empty($data['filter']['email'])): ?>
			AND `email` = "<?php echo cl_text_secure($data['filter']['email']); ?>"
		<?php endif; ?>

		<?php if(not_empty($data['filter']['status'])): ?>
			<?php if($data['filter']['status'] == 'active'): ?>
				AND `active` = "1"
			<?php elseif($data['filter']['status'] == 'blocked'): ?>
				AND `active` = "2"
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>

	ORDER BY `id` <?php echo($data['order']); ?> 

<?php if($data['limit']): ?>	
	LIMIT <?php echo($data['limit']); ?>
<?php endif; ?>