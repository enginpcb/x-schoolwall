<?php 
# @*************************************************************************@
# @ @author 松果商城									@
# @ @author_url 1: https://www.bygoukai.com/                      @
# @ @author_url 2: https://www.bygoukai.com/                     @
# @ @author_email: 18581281315@163l.com                                @
# @*************************************************************************@
# @ 松果商城- The Ultimate Modern Social Media Sharing Platform           @
# @ Copyright (c) 21.05.2021 松果商城All rights reserved.                @
# @*************************************************************************@

/**
 * 媒体文件上传接口（图片/视频）
 * 处理用户发布帖子时的媒体文件上传，支持图片和视频两种类型
 * 采用"孤儿帖子"机制：先创建临时未发布帖子存储媒体，用户最终发布时再关联
 */

// 验证用户是否已登录
if (empty($cl['is_logged'])) {
	$data         = array(
		'code'    => 401, // HTTP状态码：未授权
		'data'    => array(),
		'message' => 'Unauthorized Access'
	);
}

else {
	$data['err_code'] = 0; // 初始化错误码为0（无错误）
    $post_data        = $me['draft_post']; // 获取当前用户的草稿帖子（孤儿帖子）
    $media_type       = fetch_or_get($_POST["type"], false); // 获取上传的媒体类型（image/video）

    // 验证媒体类型是否合法
    if (empty($media_type) || in_array($media_type, array("image", "video")) != true) {
    	$data['code']     = 400; // HTTP状态码：请求错误
        $data['err_code'] = "invalid_media_type";
        $data['message']  = "Media file type is missing or invalid";
    	$data['data']     = array();
    }

    else {
    	// 处理图片上传
    	if ($media_type == "image") {
		    // 检查是否有文件上传且临时文件存在
		    if (not_empty($_FILES['file']) && not_empty($_FILES['file']['tmp_name'])) {
		        // 如果没有草稿帖子，创建一个新的孤儿帖子（临时未发布）
		        if (empty($post_data)) {
		            $post_id   = cl_create_orphan_post($me['id'], "image"); // 创建图片类型的孤儿帖子
		            $post_data = cl_get_orphan_post($post_id); // 获取刚创建的孤儿帖子数据

		            // 更新用户最后发布的帖子ID为当前孤儿帖子ID
		            cl_update_user_data($me['id'], array(
		                'last_post' => $post_id
		            ));
		        }
		        
		        // 验证孤儿帖子存在且类型为图片
		        if (not_empty($post_data) && $post_data["type"] == "image") {
		            // 限制单条帖子最多上传10张图片
		            if (empty($post_data['media']) || count($post_data['media']) < 10) {
		                // 构建文件上传参数
		                $file_info      =  array(
		                    'file'      => $_FILES['file']['tmp_name'], // 临时文件路径
		                    'size'      => $_FILES['file']['size'], // 文件大小
		                    'name'      => $_FILES['file']['name'], // 原始文件名
		                    'type'      => $_FILES['file']['type'], // MIME类型
		                    'file_type' => 'image', // 文件类型标识
		                    'folder'    => 'images', // 存储文件夹
		                    'slug'      => 'original', // 附加标识（原图）
		                    'crop'      => array('width' => 300, 'height' => 300), // 缩略图尺寸
		                    'allowed'   => 'jpg,png,jpeg,gif' // 允许的文件扩展名
		                );

		                // 执行文件上传（包含裁剪和压缩）
		                $file_upload = cl_upload($file_info);

		                // 上传成功，保存媒体信息到数据库
		                if (not_empty($file_upload['filename'])) {
		  
		                    $img_id      = cl_db_insert(T_PUBMEDIA, array(
		                        "pub_id" => $post_data["id"], // 关联的帖子ID
		                        "type"   => "image", // 媒体类型
		                        "src"    => $file_upload['filename'], // 原图路径
		                        "time"   => time(), // 上传时间
		                        "json_data" => json(array(
		                            "image_thumb" => $file_upload['cropped'] // 缩略图路径
		                        ),true)
		                    ));

		                    // 数据库插入成功，返回成功响应
		                    if (is_posnum($img_id)) {
		                    	$data['message'] = 'Media file uploaded successfully';
		                    	$data['code']    = 200; // HTTP状态码：成功
		                        $data['data']    = array(
		                        	"media_id"   => $img_id, // 媒体ID
		                        	"url"        => cl_get_media($file_upload['cropped']), // 缩略图URL
		                        	"type"       => "Image" // 媒体类型
		                        );
		                    }
		                }
		                // 上传失败，返回错误
		                else {
		                	$data['code']     = 400;
					        $data['err_code'] = "media_upload_error";
					        $data['message']  = "Something went wrong while saving a uploaded media file. Please check your details and try again";
					    	$data['data']     = array();
		                }
		            }
		            // 图片数量超过限制（10张）
		            else {
		                $data['err_code'] = "total_limit_exceeded";
		                $data['code']     = 400;
				        $data['message']  = "You cannot attach more than 10 images to a post";
				    	$data['data']     = array();
		            }
		        }
		        // 孤儿帖子不存在或类型不匹配，清理用户的孤儿帖子
		        else {
		            cl_delete_orphan_posts($me['id']); // 删除用户所有孤儿帖子
		            cl_update_user_data($me['id'],array(
		                'last_post' => 0 // 重置用户最后发布帖子ID
		            ));

		            $data['code']     = 500; // HTTP状态码：服务器内部错误
			        $data['err_code'] = "unknown_server_error";
			        $data['message']  = "An error occurred while processing your request. Please try again later.";
			    	$data['data']     = array();
		        }
		    }
		    // 没有上传文件或临时文件不存在
		    else {
		    	$data['code']     = 500;
		        $data['err_code'] = "invalid_media_file";
		        $data['message']  = "Media file is missing or invalid";
		    	$data['data']     = array();
		    }
    	}

    	// 处理视频上传
    	else if($media_type == "video") {
	    	// 检查是否有文件上传且临时文件存在
	    	if (not_empty($_FILES['file']) && not_empty($_FILES['file']['tmp_name'])) {
	            // 如果没有草稿帖子，创建一个新的孤儿帖子（临时未发布）
	            if (empty($post_data)) {
	                $post_id   = cl_create_orphan_post($me['id'], "video"); // 创建视频类型的孤儿帖子
	                $post_data = cl_get_orphan_post($post_id); // 获取刚创建的孤儿帖子数据

	                // 更新用户最后发布的帖子ID为当前孤儿帖子ID
	                cl_update_user_data($me['id'],array(
	                    'last_post' => $post_id
	                ));
	            }

	            // 验证孤儿帖子存在且类型为视频
	            if (not_empty($post_data) && $post_data["type"] == "video") {
	                // 限制单条帖子只能上传1个视频
	                if (empty($post_data['media'])) {
	                    // 构建文件上传参数
	                    $file_info      =  array(
	                        'file'      => $_FILES['file']['tmp_name'], // 临时文件路径
	                        'size'      => $_FILES['file']['size'], // 文件大小
	                        'name'      => $_FILES['file']['name'], // 原始文件名
	                        'type'      => $_FILES['file']['type'], // MIME类型
	                        'file_type' => 'video', // 文件类型标识
	                        'folder'    => 'videos', // 存储文件夹
	                        'slug'      => 'original', // 附加标识（原视频）
	                        'allowed'   => 'mp4,mov,3gp,webm', // 允许的文件扩展名
	                    );

	                    // 执行视频文件上传
	                    $file_upload = cl_upload($file_info);
	                    $upload_fail = false; // 上传失败标记
	                    $post_id     = $post_data['id']; // 关联的帖子ID

	                    // 视频上传成功，生成视频封面图
	                    if (not_empty($file_upload['filename'])) {
	                        try {
	                            // 引入FFmpeg PHP库
	                            require_once(cl_full_path("core/libs/ffmpeg-php/vendor/autoload.php"));

	                            // 初始化FFmpeg实例（使用配置中的二进制文件路径）
	                            $ffmpeg         = new FFmpeg(cl_full_path($config['ffmpeg_binary']));
	                            // 生成视频封面图的存储路径（第3秒的帧）
	                            $thumb_path     = cl_gen_path(array(
	                                "folder"    => "images",
	                                "file_ext"  => "jpeg",
	                                "file_type" => "image",
	                                "slug"      => "poster",
	                            ));

	                            // FFmpeg命令：截取视频第3秒的一帧作为封面图
	                            $ffmpeg->input($file_upload['filename']);
	                            $ffmpeg->set('-ss','3'); // 从第3秒开始
	                            $ffmpeg->set('-vframes','1'); // 只截取1帧
	                            $ffmpeg->set('-f','mjpeg'); // 输出格式为JPEG
	                            $ffmpeg->output($thumb_path)->ready(); // 执行并保存到指定路径
	                        } 

	                        // FFmpeg处理失败，标记上传失败
	                        catch (Exception $e) {
	                            $upload_fail = true;
	                        }

	                        // 封面图生成成功，保存视频信息到数据库
	                        if (empty($upload_fail)) {
	                            $vid_id      = cl_db_insert(T_PUBMEDIA, array(
	                                "pub_id" => $post_id, // 关联的帖子ID
	                                "type"   => "video", // 媒体类型
	                                "src"    => $file_upload['filename'], // 原视频路径
	                                "time"   => time(), // 上传时间
	                                "json_data" => json(array(
	                                    "poster_thumb" => $thumb_path // 视频封面图路径
	                                ),true)
	                            ));

	                            // 数据库插入成功，返回成功响应
	                            if (is_posnum($vid_id)) {
	                                $data['message'] = 'Media file uploaded successfully';
			                    	$data['code']    = 200; // HTTP状态码：成功
			                        $data['data']    = array(
			                        	"media_id"   => $vid_id, // 媒体ID
			                        	"type"       => "Video", // 媒体类型
			                        	"source"     => cl_get_media($file_upload['filename']), // 原视频URL
	                                    "poster"     => cl_get_media($thumb_path), // 封面图URL
			                        );
	                            }
	                        }

	                        // 封面图生成失败，返回错误
	                        else {
			                	$data['code']     = 400;
						        $data['err_code'] = "media_upload_error";
						        $data['message']  = "Something went wrong while saving a uploaded media file. Please check your details and try again";
						    	$data['data']     = array();
			                }
	                    }
	                }
	                // 视频数量超过限制（1个）
	                else {
	                    $data['err_code'] = "total_limit_exceeded";
		                $data['code']     = 400;
				        $data['message']  = "You cannot attach more than 1 video to a post";
				    	$data['data']     = array();
	                }
	            }
	            // 孤儿帖子不存在或类型不匹配，清理用户的孤儿帖子
	            else {
	                cl_delete_orphan_posts($me['id']); // 删除用户所有孤儿帖子
	                cl_update_user_data($me['id'], array(
	                    'last_post' => 0 // 重置用户最后发布帖子ID
	                ));
	            }
	        }

	        // 没有上传文件或临时文件不存在
	        else {
		    	$data['code']     = 500;
		        $data['err_code'] = "invalid_media_file";
		        $data['message']  = "Media file is missing or invalid";
		    	$data['data']     = array();
		    }
    	}
    }
}