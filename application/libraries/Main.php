<?php

Class Main
{

    private $ci;
    private $web_name = 'Fantasy Online';
    private $web_url = 'fantasy-online.com';
    private $file_info = 'Images with resolution 600px x 600px';
    private $file_info_slider = 'Images with resolution 1920px x 950px and size 250KB';
    private $path_images = 'upload/images/';
    private $image_size_preview = 200;
    private $help_thumbnail_alt = 'Penting untuk SEO Gambar';
    private $help_meta = 'Penting untuk SEO Halaman Website';
    private $short_desc_char = 100;

    public function __construct()
    {
        error_reporting(0);
        $this->ci =& get_instance();
    }

    function short_desc($string)
    {
        return substr(strip_tags($string), 0, $this->short_desc_char) . ' ...';
    }

    function web_name()
    {
        return $this->web_name;
    }

    function web_url()
    {
        return $this->web_url;
    }

    function credit()
    {
        return 'development by <a href="https://www.redsystem.id">Red System - Web Development</a>';
    }

    function date_view($date)
    {
        return date('d F Y', strtotime($date));
    }

    function format_tanggal($originaldate)
    {
        return date('d-m-Y', strtotime($originaldate));
    }

    function help_thumbnail_alt()
    {
        return $this->help_thumbnail_alt;
    }

    function help_meta()
    {
        return $this->help_meta;
    }

    function file_info()
    {
        return $this->file_info;
    }

    function file_info_slider()
    {
        return $this->file_info_slider;
    }

    function path_images()
    {
        return $this->path_images;
    }

    function image_size_preview()
    {
        return $this->image_size_preview;
    }

    function image_preview_url($filename)
    {
        return base_url($this->path_images . $filename);
    }

    function delete_file($filename)
    {
        if ($filename) {
            if (file_exists(FCPATH . $this->path_images . $filename)) {
				unlink(FCPATH . $this->path_images . $filename);
            }
        }
    }

    function data_main($menu_active=null)
    {
        // Default :
//        $id_language = $this->ci->session->userdata('id_language') ?
//            $this->ci->session->userdata('id_language') :
//            $this->ci->db->select('id')->where('use', 'yes')->order_by('id', 'ASC')->get('language')->row()->id;

        $id_language = $this->ci->session->userdata('id_language') ?
            $this->ci->session->userdata('id_language') :
            $this->ci->db->select('id')->where(array('use' => 'yes', 'code' => 'id'))->order_by('id', 'ASC')->get('language')->row()->id;

        $contact_info = $this->ci->db->where('use','yes')->get('contact_info')->result();

        $data = array(
            'web_name' => $this->web_name,
            'menu_list' => $this->menu_list(),
            'name' => $this->ci->session->userdata('name'),
            'language' => $this->ci->db->where('use', 'yes')->get('language')->result(),
            'id_language' => $id_language,
        );

        $tab_language = $this->ci->load->view('admins/components/tab_language', $data, TRUE);
        $data['tab_language'] = $tab_language;
        $data['current_url'] = $menu_active ? $menu_active : current_url();

        foreach ($contact_info as $contact){
            $data['contact_info'][$contact->type] = $contact->description;
        }

        return $data;
    }

    function data_front()
    {
        $lang_code = $this->ci->lang->lang();
        $lang_active = $this->ci->db->where('code', $lang_code)->get('language')->row();
        $footer = $this->ci->db->select('description')->where(array('type' => 'footer', 'id_language' => $lang_active->id))->get('pages')->row()->description;
//		$service_list = $this->ci->db->select('title,id')->where('id_language', $lang_active->id)->order_by('title', 'ASC')->get('category')->result();
//        $category_product = $this->ci->db->where(array('id_language' => $lang_active->id, 'use' => 'yes'))->get('products_category')->result();
        $category_product = $this->ci->db->where(array('use' => 'yes'))->get('products_category')->result();
        foreach ($category_product as $category) {
            $sub_category = $this->ci->db->where(array('id_parent_category' => $category->id, 'use' => 'yes'))->get('products_sub_category')->result();
            if (!empty($sub_category)) {
                $sub_category_product[$category->id] = $sub_category;
            }
        }
        $language_list = $this->ci->db->where('use', 'yes')->order_by('title', 'ASC')->get('language')->result();
//        $popup_trial = $this->ci->db->where(array('id_language' => $lang_active->id, 'type' => 'free_trial'))->get('pages')->row();
        $show_hide = FALSE;
        $menu_list = $this->ci
            ->db
            ->select('title_menu, type')
            ->where('controller_method is NOT NULL', NULL, FALSE)
            ->where('id_language', $lang_active->id)
            ->get('pages')
            ->result();
        $dictionary = $this->ci->db->where('id_language', $lang_active->id)->get('dictionary')->result();
        $home = $this->ci->db->where(array('type' => 'home', 'id_language' => $lang_active->id))->get('pages')->row();
        $contact_info = $this->ci->db->where('use','yes')->get('contact_info')->result();

        $data = array(
            'view_secret' => FALSE,
            'author' => 'www.fantasy-online.id',
//			'services_list' => $service_list,
            'category_product' => $category_product,
            'sub_category_product' => $sub_category_product,
            'language_list' => $language_list,
            'lang_code' => $lang_code,
            'lang_active' => $lang_active,
            'id_language' => $lang_active->id,
            'footer' => $footer,
//            'popup_trial' => $popup_trial,
//            'captcha' => $this->captcha(),
            'show_hide' => $show_hide,
            'home' => $home,
        );


        foreach ($contact_info as $contact){
            $data['contact_info'][$contact->type] = $contact->description;
        }

        foreach($dictionary as $row) {
            $data['dict_'.$row->dict_variable] = $row->dict_word;
        }

        foreach ($menu_list as $row) {
            $data[$row->type] = $row;
        }

//        echo json_encode($data);
//        exit;

        return $data;
    }

    function translate_number($number)
    {
        switch ($number) {
            case 1:
                return "first";
                break;
            case 2:
                return "second";
                break;
            case 3:
                return "third";
                break;
            case 4:
                return "four";
                break;
        }
    }

    function check_admin()
    {
        if ($this->ci->session->userdata('status') !== 'login') {
            redirect('proweb');
        }
    }

    function check_login()
    {
        if ($this->ci->session->userdata('status') == 'login') {
            redirect('proweb/dashboard');
        }
    }

    function check_member()
    {
        if ($this->ci->session->userdata('status_member') !== 'login') {
            redirect('login');
        }
    }

    function check_login_member()
    {
        if ($this->ci->session->userdata('status_member') == 'login') {
            redirect(site_url('user-profile/'));
        }
    }

    function permalink($data)
    {
        $slug = '';
        foreach ($data as $r) {
            $slug .= $this->slug($r) . '/';
        }

        return site_url($slug);
    }

    function breadcrumb($data)
    {
        $breadcrumb = '<ul class="breadcrumb">';
        $count = count($data);
        $no = 1;
        foreach ($data as $url => $label) {
            $current = '';
            if ($no == $count) {
                $current = ' class="current"';
            }

            $breadcrumb .= '<li' . $current . '><a href="' . $url . '">' . $label . '</a></li>';
        }

        $breadcrumb .= '</ul>';


        return $breadcrumb;
    }

    function remove_special_characters($text){
        $string = preg_replace('/[^\da-z ]/i', '', $text);

        return $string;
    }

    function slug($text)
    {

        $find = array(' ', '/', '&', '\\', '\'', ',', '(', ')', '?','/\t+/');
        $replace = array('-', '-', 'and', '-', '-', '-', '', '', '','-');

        $text = self::normalizeChars($text);
        $slug = str_replace($find, $replace, strtolower($text));

        return $slug;
    }

    function date_format_view($date)
    {
        return date('d M Y', strtotime($date));
    }

    function day_format_view($date)
    {
        return date('d', strtotime($date));
    }

    function month_format_view($date)
    {
        return date('M', strtotime($date));
    }

    function year_format_view($date)
    {
        return date('Y', strtotime($date));
    }

    function slug_back($slug)
    {
        $slug = trim($slug);
        if (empty($slug)) return '';
        $slug = str_replace('-', ' ', $slug);
        $slug = ucwords($slug);
        return $slug;
    }

    function upload_file_thumbnail($fieldname, $filename)
    {
        $config['upload_path'] = './upload/images/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 10000;
        $config['max_width'] = 80000;
        $config['max_height'] = 60000;
//		$config['overwrite'] = TRUE;
        $config['file_name'] = $this->slug($this->remove_special_characters($filename));
        $this->ci->load->library('upload', $config);
        $this->ci->load->library('tinypng', array('api_key' => '37N46FSdsBb3qmJvt0GdwJ0R83pHW4kR'));

        if (!$this->ci->upload->do_upload($fieldname)) {
            return array(
                'status' => FALSE,
                'message' => $this->ci->upload->display_errors()
            );
        } else {
            $data_img = $this->ci->upload->data();
            $this->ci->tinypng->fileCompress($data_img['full_path'], $data_img['full_path']);
            return array(
                'status' => TRUE,
                'filename' => $data['thumbnail'] = $this->ci->upload->file_name
            );
        }
    }

    function upload_file_slider($fieldname, $filename)
    {
        $config['upload_path'] = './upload/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 250;
        $config['max_width'] = 1920;
        $config['max_height'] = 950;
//		$config['overwrite'] = TRUE;
        $config['file_name'] = $this->slug($this->remove_special_characters($filename));
        $this->ci->load->library('upload', $config);
        $this->ci->load->library('tinypng', array('api_key' => '37N46FSdsBb3qmJvt0GdwJ0R83pHW4kR'));

        if (!$this->ci->upload->do_upload($fieldname)) {
            return array(
                'status' => FALSE,
                'message' => $this->ci->upload->display_errors()
            );
        } else {
            $data_img = $this->ci->upload->data();
            $this->ci->tinypng->fileCompress($data_img['full_path'], $data_img['full_path']);

            return array(
                'status' => TRUE,
                'filename' => $data['thumbnail'] = $this->ci->upload->file_name
            );
        }
    }

    function upload_file_custom($fieldname, $filename, $width, $height)
    {
        $config['upload_path'] = './upload/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 10000;
        $config['max_width'] = 80000;
        $config['max_height'] = 60000;
//		$config['overwrite'] = TRUE;
        $config['file_name'] = $this->slug($this->remove_special_characters($filename));
        $this->ci->load->library('upload', $config);
        $this->ci->load->library('tinypng', array('api_key' => '37N46FSdsBb3qmJvt0GdwJ0R83pHW4kR'));

        if (!$this->ci->upload->do_upload($fieldname)) {
            return array(
                'status' => FALSE,
                'message' => $this->ci->upload->display_errors()
            );
        } else {
            $fInfo = $this->ci->upload->data(); // get all info of uploaded file
            //for image resize
            $img_array = array();
            $img_array['image_library'] = 'gd2';
            $img_array['maintain_ratio'] = TRUE;
            $img_array['create_thumb'] = FALSE;
            //you need this setting to tell the image lib which image to process
            $img_array['source_image'] = $fInfo['full_path'];
            list($image_width, $image_height) = getimagesize($fInfo['file_name']);

            if ($image_width >= $image_height) {
                $img_array['width'] = $width;
            } else {
                $img_array['height'] = $height;
            }
            $img_array['master_dim'] = 'auto';

//            $img_array['height'] = $height;
//            $img_array['width'] = $width;

            $this->ci->load->library('image_lib', $img_array);

            if (!$this->ci->image_lib->resize()) {
                return array(
                    'status' => FALSE,
                );
            }

            array('upload_data' => $this->ci->upload->data());

            $data_img = $this->ci->upload->data();
            $this->ci->tinypng->fileCompress($data_img['full_path'], $data_img['full_path']);

            return array(
                'status' => TRUE,
                'filename' => $data['thumbnail'] = $this->ci->upload->file_name
            );
        }
    }

    function adjustPicOrientation($full_filename)
    {
        $exif = $this->ci->exif_read_data($full_filename);
        if($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){
                $img = $this->ci->imagecreatefromjpeg($full_filename);

                $mirror = false;
                $deg    = 0;

                switch ($orientation) {
                  case 2:
                    $mirror = true;
                    break;
                  case 3:
                    $deg = 180;
                    break;
                  case 4:
                    $deg = 180;
                    $mirror = true;
                    break;
                  case 5:
                    $deg = 270;
                    $mirror = true;
                    break;
                  case 6:
                    $deg = 270;
                    break;
                  case 7:
                    $deg = 90;
                    $mirror = true;
                    break;
                  case 8:
                    $deg = 90;
                    break;
                }
                if ($deg) $img = $this->ci->imagerotate($img, $deg, 0);
                if ($mirror) $img = $this->_mirrorImage($img);
                $full_filename = str_replace('.jpg', "-O$orientation.jpg",  $full_filename);
                $this->ci->imagejpeg($img, $full_filename, 95);
            }
        }
        return $full_filename;
    }

    function _mirrorImage ($imgsrc)
    {
        $width = imagesx ( $imgsrc );
        $height = imagesy ( $imgsrc );

        $src_x = $width -1;
        $src_y = 0;
        $src_width = -$width;
        $src_height = $height;

        $imgdest = imagecreatetruecolor ( $width, $height );

        if ( imagecopyresampled ( $imgdest, $imgsrc, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height ) )
        {
            return $imgdest;
        }

        return $imgsrc;
    }

    function captcha()
    {
        $this->ci->load->helper(array('captcha', 'string'));
        $this->ci->load->library('session');

        $vals = array(
            'img_path' => './upload/images/captcha/',
            'img_url' => base_url() . 'upload/images/captcha',
            'img_width' => '200',
            'img_height' => 35,
            'border' => 0,
            'expiration' => 7200,
            'word' => random_string('numeric', 5)
        );

        // create captcha image
        $cap = create_captcha($vals);

        // store image html code in a variable
        $captcha = $cap['image'];

        // store the captcha word in a session
        //$cap['word'];
        $this->ci->session->set_userdata('captcha_mwz', $cap['word']);

        return $captcha;
    }

    function share_link($socmed_type, $title, $link)
    {
        switch ($socmed_type) {
            case "facebook":
                return "https://www.facebook.com/sharer/sharer.php?u=" . $link;
                break;
            case "twitter":
                return "https://twitter.com/home?status=" . $link;
                break;
            case "googleplus":
                return "https://plus.google.com/share?url=" . $link;
                break;
            case "linkedin":
                return "https://www.linkedin.com/shareArticle?mini=true&url=" . $link . "&title=" . $title . "&summary=&source=";
                break;
            case "pinterest":
                return "https://pinterest.com/pin/create/button/?url=" . $title . "&media=" . $link . "&description=";
                break;
            case "email":
                return "mailto:" . $link . "?&subject=" . $title;
            default:
                return $link;
                break;
        }
    }


    public static function normalizeChars($s) {
        $replace = array(
            'ъ'=>'-', 'Ь'=>'-', 'Ъ'=>'-', 'ь'=>'-',
            'Ă'=>'A', 'Ą'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
            'Þ'=>'B',
            'Ć'=>'C', 'ץ'=>'C', 'Ç'=>'C',
            'È'=>'E', 'Ę'=>'E', 'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
            'Ğ'=>'G',
            'İ'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
            'Ł'=>'L',
            'Ñ'=>'N', 'Ń'=>'N',
            'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
            'Ş'=>'S', 'Ś'=>'S', 'Ș'=>'S', 'Š'=>'S',
            'Ț'=>'T',
            'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
            'Ý'=>'Y',
            'Ź'=>'Z', 'Ž'=>'Z', 'Ż'=>'Z',
            'â'=>'a', 'ǎ'=>'a', 'ą'=>'a', 'á'=>'a', 'ă'=>'a', 'ã'=>'a', 'Ǎ'=>'a', 'а'=>'a', 'А'=>'a', 'å'=>'a', 'à'=>'a', 'א'=>'a', 'Ǻ'=>'a', 'Ā'=>'a', 'ǻ'=>'a', 'ā'=>'a', 'ä'=>'ae', 'æ'=>'ae', 'Ǽ'=>'ae', 'ǽ'=>'ae',
            'б'=>'b', 'ב'=>'b', 'Б'=>'b', 'þ'=>'b',
            'ĉ'=>'c', 'Ĉ'=>'c', 'Ċ'=>'c', 'ć'=>'c', 'ç'=>'c', 'ц'=>'c', 'צ'=>'c', 'ċ'=>'c', 'Ц'=>'c', 'Č'=>'c', 'č'=>'c', 'Ч'=>'ch', 'ч'=>'ch',
            'ד'=>'d', 'ď'=>'d', 'Đ'=>'d', 'Ď'=>'d', 'đ'=>'d', 'д'=>'d', 'Д'=>'D', 'ð'=>'d',
            'є'=>'e', 'ע'=>'e', 'е'=>'e', 'Е'=>'e', 'Ə'=>'e', 'ę'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'Ē'=>'e', 'Ė'=>'e', 'ė'=>'e', 'ě'=>'e', 'Ě'=>'e', 'Є'=>'e', 'Ĕ'=>'e', 'ê'=>'e', 'ə'=>'e', 'è'=>'e', 'ë'=>'e', 'é'=>'e',
            'ф'=>'f', 'ƒ'=>'f', 'Ф'=>'f',
            'ġ'=>'g', 'Ģ'=>'g', 'Ġ'=>'g', 'Ĝ'=>'g', 'Г'=>'g', 'г'=>'g', 'ĝ'=>'g', 'ğ'=>'g', 'ג'=>'g', 'Ґ'=>'g', 'ґ'=>'g', 'ģ'=>'g',
            'ח'=>'h', 'ħ'=>'h', 'Х'=>'h', 'Ħ'=>'h', 'Ĥ'=>'h', 'ĥ'=>'h', 'х'=>'h', 'ה'=>'h',
            'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'į'=>'i', 'ĭ'=>'i', 'ı'=>'i', 'Ĭ'=>'i', 'И'=>'i', 'ĩ'=>'i', 'ǐ'=>'i', 'Ĩ'=>'i', 'Ǐ'=>'i', 'и'=>'i', 'Į'=>'i', 'י'=>'i', 'Ї'=>'i', 'Ī'=>'i', 'І'=>'i', 'ї'=>'i', 'і'=>'i', 'ī'=>'i', 'ĳ'=>'ij', 'Ĳ'=>'ij',
            'й'=>'j', 'Й'=>'j', 'Ĵ'=>'j', 'ĵ'=>'j', 'я'=>'ja', 'Я'=>'ja', 'Э'=>'je', 'э'=>'je', 'ё'=>'jo', 'Ё'=>'jo', 'ю'=>'ju', 'Ю'=>'ju',
            'ĸ'=>'k', 'כ'=>'k', 'Ķ'=>'k', 'К'=>'k', 'к'=>'k', 'ķ'=>'k', 'ך'=>'k',
            'Ŀ'=>'l', 'ŀ'=>'l', 'Л'=>'l', 'ł'=>'l', 'ļ'=>'l', 'ĺ'=>'l', 'Ĺ'=>'l', 'Ļ'=>'l', 'л'=>'l', 'Ľ'=>'l', 'ľ'=>'l', 'ל'=>'l',
            'מ'=>'m', 'М'=>'m', 'ם'=>'m', 'м'=>'m',
            'ñ'=>'n', 'н'=>'n', 'Ņ'=>'n', 'ן'=>'n', 'ŋ'=>'n', 'נ'=>'n', 'Н'=>'n', 'ń'=>'n', 'Ŋ'=>'n', 'ņ'=>'n', 'ŉ'=>'n', 'Ň'=>'n', 'ň'=>'n',
            'о'=>'o', 'О'=>'o', 'ő'=>'o', 'õ'=>'o', 'ô'=>'o', 'Ő'=>'o', 'ŏ'=>'o', 'Ŏ'=>'o', 'Ō'=>'o', 'ō'=>'o', 'ø'=>'o', 'ǿ'=>'o', 'ǒ'=>'o', 'ò'=>'o', 'Ǿ'=>'o', 'Ǒ'=>'o', 'ơ'=>'o', 'ó'=>'o', 'Ơ'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
            'פ'=>'p', 'ף'=>'p', 'п'=>'p', 'П'=>'p',
            'ק'=>'q',
            'ŕ'=>'r', 'ř'=>'r', 'Ř'=>'r', 'ŗ'=>'r', 'Ŗ'=>'r', 'ר'=>'r', 'Ŕ'=>'r', 'Р'=>'r', 'р'=>'r',
            'ș'=>'s', 'с'=>'s', 'Ŝ'=>'s', 'š'=>'s', 'ś'=>'s', 'ס'=>'s', 'ş'=>'s', 'С'=>'s', 'ŝ'=>'s', 'Щ'=>'sch', 'щ'=>'sch', 'ш'=>'sh', 'Ш'=>'sh', 'ß'=>'ss',
            'т'=>'t', 'ט'=>'t', 'ŧ'=>'t', 'ת'=>'t', 'ť'=>'t', 'ţ'=>'t', 'Ţ'=>'t', 'Т'=>'t', 'ț'=>'t', 'Ŧ'=>'t', 'Ť'=>'t', '™'=>'tm',
            'ū'=>'u', 'у'=>'u', 'Ũ'=>'u', 'ũ'=>'u', 'Ư'=>'u', 'ư'=>'u', 'Ū'=>'u', 'Ǔ'=>'u', 'ų'=>'u', 'Ų'=>'u', 'ŭ'=>'u', 'Ŭ'=>'u', 'Ů'=>'u', 'ů'=>'u', 'ű'=>'u', 'Ű'=>'u', 'Ǖ'=>'u', 'ǔ'=>'u', 'Ǜ'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'У'=>'u', 'ǚ'=>'u', 'ǜ'=>'u', 'Ǚ'=>'u', 'Ǘ'=>'u', 'ǖ'=>'u', 'ǘ'=>'u', 'ü'=>'ue',
            'в'=>'v', 'ו'=>'v', 'В'=>'v',
            'ש'=>'w', 'ŵ'=>'w', 'Ŵ'=>'w',
            'ы'=>'y', 'ŷ'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Ŷ'=>'y',
            'Ы'=>'y', 'ž'=>'z', 'З'=>'z', 'з'=>'z', 'ź'=>'z', 'ז'=>'z', 'ż'=>'z', 'ſ'=>'z', 'Ж'=>'zh', 'ж'=>'zh'
        );
        return strtr($s, $replace);
    }

    function format_money($number)
    {
        return number_format($number,null,null,".");
    }

    function mailer_auth($subject, $to_email, $to_name, $body, $file = '', $embed_image = '')
    {
        $this->ci->load->library('my_phpmailer');
        $mail = new PHPMailer;

        try {
            $mail->IsSMTP();
            $mail->SMTPSecure = "tls"; //ssl (untuk ketika diupload)
            $mail->Host = "fantasyonline.id"; //hostname masing-masing provider email
//            $mail->SMTPDebug = 2;
            $mail->SMTPDebug = FALSE;
            $mail->do_debug = 0;
            $mail->Port = 587; //465 (untuk ketika dimasukkan portnya waktu diupload)
            $mail->SMTPAuth = true;
            $mail->Username = "no-reply@fantasyonline.id"; //user email
            $mail->Password = "S*GzapiFX[{1"; //password email
            $mail->SetFrom("no-reply@fantasyonline.id", $this->web_name); //set email pengirim
            $mail->Subject = $subject; //subyek email
            $mail->AddAddress($to_email, $to_name); //tujuan email
            $mail->MsgHTML($body);
            if ($file) {
                $mail->addAttachment("upload/images/" . $file);
            }

            if(!$mail->Send()) {
                $data = array(
                    'success' => false,
                    'error' => $mail->ErrorInfo,
                );
            } else {
                $data = array(
                    'success' => true,
                    'error' => $mail->ErrorInfo,
                );
            }
            return (object) $data;
            //echo "Message has been sent";
        } catch (phpmailerException $e) {
            return $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            return $e->getMessage(); //Boring error messages from anything else!
        }
    }

    function count_discount($normal_price, $promotion_price){
        return round((($normal_price - $promotion_price) / $normal_price) * 100, 0);
    }

    function trim_number_wa($value)
    {
        $trimmed = '';
        if (substr($value,0,2) === '08') {
            $trimmed = '+62'.substr($value,1);
        } else if (substr($value,0,2) === '62') {
            $trimmed = '+'.$value;
        } else {
            $trimmed = $value;
        }
        return $trimmed;
    }

    function checkout_respond_time()
    {
        date_default_timezone_set("Asia/Makassar");
        $date=date(Ymd);
        // var_dump($date);
        $hari = date('l', strtotime($date));
        $waktu = date('H:i:s');    
        $status = 'tutup';
        $tanggal_sekarang = date('Y-m-d');
        
        // var_dump($tanggal_sekarang);
        // die();
        $get_hari    = $this->ci->db->query("SELECT hari,jam_tutup from timeoperation where hari = '".$hari."' ")->row();
        $get_tanggal = $this->ci->db->query("SELECT * FROM `holiday_checkout` WHERE date_start <= '".$tanggal_sekarang."' OR '".$tanggal_sekarang."' >= date_finish")->row();
        $respon = array();  
        // var_dump($get_hari->jam_tutup);
        // var_dump($get_tanggal);
        // die();
        if(time() >= strtotime($get_hari->jam_tutup))
        {
            $status = 'tutup';
        }
        else
        {
            $status = 'buka';
        }
        $status_libur = 'buka';

        // if( strtotime($tanggal_sekarang) >= strtotime($get_tanggal->date_start) || strtotime($tanggal_sekarang) <= strtotime($get_tanggal->date_finish) ){
        if( !empty($get_tanggal)){
            $status_libur = 'libur';
        }
        else
        {
            $status_libur = 'buka';
        }
        $respon = array(
            'status' => $status,
            'status_libur' => $status_libur,
            'tanggal_mulai_libur' => date('d-m-Y', strtotime($get_tanggal->date_start)),
            'tanggal_selesai_libur'=> date('d-m-Y',strtotime($get_tanggal->date_finish)) 
        );
        return $respon;
    }

    function checkout_respond_date()
    {
        $date=date(Ymds);
        $status='libur';
        $tanggal = date('l', strtotime($date));
        $get_tanggal = $this->ci->db->query("SELECT date_start,date_finish from holiday_checkout where date_start='".$tanggal."' ")->row();
        if(date()){
            $status = 'libur';
        }
        else
        {
            $status = 'masuk';
        }
        return $status;
    }

    function menu_list()
    {
        $menu = array(
            'MAIN' => array(
                'dashboard' => array(
                    'label' => 'Dashboard',
                    'route' => base_url('proweb/dashboard'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
                'view_front' => array(
                    'label' => 'View Website',
                    'route' => base_url(''),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                )
            ),
            'PAGES' => array(
                'home' => array(
                    'label' => 'Home',
                    'route' => 'javascript:;',
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array(
                        'home_page' => array(
                            'label' => 'Home Page',
                            'route' => base_url('proweb/pages/type/home'),
                            'icon' => 'fab fa-asymmetrik',
                            'form_input' => array(
                                'judul_top_menu' => true,
                                'judul_halaman' => true,
                                'description' => false,
                                'thumbnail' => false,
                                'file' => false,
                                'status_sub_konten' => false,
                                'status_sub_judul_section' => false,
                                'status_sub_deskripsi_section' => false,
                                'status_sub_judul' => false,
                                'status_sub_deskripsi' => false,
                                'status_sub_gambar' => false,
                                'status_sub_gambar_deskripsi' => false,
                            )
                        ),
                        'home_slider' => array(
                            'label' => 'Slider Section',
                            'route' => base_url('proweb/home_slider'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'home_banner' => array(
                            'label' => 'Banner Section',
                            'route' => base_url('proweb/home_banner'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'sesi_1' => array(
                            'label' => 'Best Selling Section',
                            'route' => base_url('proweb/pages/type/home_sesi_1'),
                            'icon' => 'fab fa-asymmetrik',
                            'form_input' => array(
                                'judul_top_menu' => true,
                                'judul_halaman' => true,
                                'sub_judul' => false,
                                'description' => false,
                                'thumbnail' => false,
                                'file' => false,
                                'status_sub_konten' => false,
                                'status_sub_judul_section' => false,
                                'status_sub_deskripsi_section' => false,
                                'status_sub_judul' => false,
                                'status_sub_deskripsi' => false,
                                'status_sub_gambar' => false,
                                'status_sub_gambar_deskripsi' => false,
                            )
                        ),
                        'sesi_2' => array(
                            'label' => 'New Product Section',
                            'route' => base_url('proweb/pages/type/home_sesi_2'),
                            'icon' => 'fab fa-asymmetrik',
                            'form_input' => array(
                                'judul_top_menu' => true,
                                'judul_halaman' => true,
                                'sub_judul' => false,
                                'description' => false,
                                'thumbnail' => false,
                                'file' => false,
                                'status_sub_konten' => false,
                                'status_sub_judul_section' => false,
                                'status_sub_deskripsi_section' => false,
                                'status_sub_judul' => false,
                                'status_sub_deskripsi' => false,
                                'status_sub_gambar' => false,
                                'status_sub_gambar_deskripsi' => false,
                            )
                        ),
                        'home_products_by_category' => array(
                            'label' => 'Product by Category List Section',
                            'route' => base_url('proweb/home_products_by_category'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
//                        'sesi_7' => array(
//                            'label' => 'Sesi Ajakan Book Now',
//                            'route' => base_url('proweb/pages/type/home_sesi_7'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'sesi_8' => array(
//                            'label' => 'Sesi Ajakan Subscribe',
//                            'route' => base_url('proweb/pages/type/home_sesi_8'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'sesi_9' => array(
//                            'label' => 'Sesi Ajakan Book now',
//                            'route' => base_url('proweb/pages/type/home_sesi_9'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
                    )
                ),
//                'profile' => array(
//                    'label' => 'About Us',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'profile_page' => array(
//                            'label' => 'About Us Page',
//                            'route' => base_url('proweb/pages/type/about'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
////                        'profile_team' => array(
////                            'label' => 'Daftar Team',
////                            'route' => base_url('proweb/profile_team'),
////                            'icon' => 'fab fa-asymmetrik'
////                        ),
//                    )
//                ),
                'shop' => array(
                    'label' => 'Products',
                    'route' => 'javascript:;',
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array(
                        'shop_page' => array(
                            'label' => 'Products Page',
                            'route' => base_url('proweb/pages/type/shop'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'shop_category_list' => array(
                            'label' => 'Products Category',
                            'route' => base_url('proweb/products_category'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
//                        'shop_region_list' => array(
//                            'label' => 'Shop Region',
//                            'route' => base_url('proweb/wine_region'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
                        'shop_list' => array(
                            'label' => 'Products List',
                            'route' => base_url('proweb/products_content'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                    ),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => false,
                        'description' => false,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => false,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => false,
                        'status_sub_deskripsi' => false,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_deskripsi' => false,
                    )
                ),
//                'promotion' => array(
//                    'label' => 'Promotion',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'shop_page' => array(
//                            'label' => 'Promotion Page',
//                            'route' => base_url('proweb/pages/type/promotion'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'shop_list' => array(
//                            'label' => 'Promotion List',
//                            'route' => base_url('proweb/promotion_content/index/wine'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
//                'blog' => array(
//                    'label' => 'Blog',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'blog_page' => array(
//                            'label' => 'Blog Page',
//                            'route' => base_url('proweb/pages/type/blog'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'blog_category' => array(
//                            'label' => 'Blog Category',
//                            'route' => base_url('proweb/blog_category'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'blog_list' => array(
//                            'label' => 'Blog List',
//                            'route' => base_url('proweb/blog_content'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
//                'event' => array(
//                    'label' => 'Event',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'event_page' => array(
//                            'label' => 'Event Page',
//                            'route' => base_url('proweb/pages/type/event'),
//                            'icon' => 'fab fa-asymmetrik',
//                        ),
//                        'event_category' => array(
//                            'label' => 'Event Category',
//                            'route' => base_url('proweb/event_category'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'event_list' => array(
//                            'label' => 'Event List',
//                            'route' => base_url('proweb/event_content'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
				'data_checkout' => array(
					'label' => 'Checkout',
					'route' => 'javascript:;',
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array(
					    'checkout_page' => array(
                            'label' => 'Checkout Page',
                            'route' => base_url('proweb/pages/type/checkout'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'checkout_list' => array(
                            'label' => 'Checkout List',
                            'route' => base_url('proweb/checkout'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'checkout_payment' => array(
                            'label' => 'Checkout Payment',
                            'route' => base_url('proweb/checkout_payment'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'checkout_report_recap' => array(
                            'label' => 'Rekap Laporan Penjualan',
                            'route' => base_url('proweb/checkout_report_recap'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'time_operation_checkout' =>array(
                            'label' => 'Time Operation Checkout',
                            'route' => base_url('proweb/time_operation'),
                            'icon'  => 'fab fa-asymmetrik'
                        ),
                        'holiday_checkout' =>array(
                            'label' => 'Holiday Checkout',
                            'route' => base_url('proweb/Holiday_checkout'),
                            'icon'  => 'fab fa-asymmetrik'
                        )
                    ),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => true,
                        'description' => false,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => false,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => false,
                        'status_sub_deskripsi' => false,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_deskripsi' => false,
                    )
				),
                'contact_us' => array(
                    'label' => 'Contact Us',
                    'route' => 'javascript:;',
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array(
					    'checkout_page' => array(
                            'label' => 'Contact Us Page',
                            'route' => base_url('proweb/pages/type/contact_us'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                        'checkout_list' => array(
                            'label' => 'Contact Us Info',
                            'route' => base_url('proweb/contact_info'),
                            'icon' => 'fab fa-asymmetrik'
                        ),
                    ),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => true,
                        'description' => true,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => false,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => false,
                        'status_sub_deskripsi' => false,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_note' => 'Please insert image with 1x1 ratio for optimal looks',
                        'status_sub_gambar_deskripsi' => false,
                    )
                ),
				'list_member' => array(
					'label' => 'List Member',
					'route' => base_url('proweb/list_member'),
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array()
				),
				'terms_condition' => array(
					'label' => 'Terms & Condition',
					'route' => base_url('proweb/pages/type/terms_condition'),
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array(),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => true,
                        'description' => true,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => false,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => false,
                        'status_sub_deskripsi' => false,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_note' => 'Please insert image with 1x1 ratio for optimal looks',
                        'status_sub_gambar_deskripsi' => false,
                    )
				),
				'about_us' => array(
					'label' => 'About Us',
					'route' => base_url('proweb/pages/type/about_us'),
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array(),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => true,
                        'description' => true,
                        'thumbnail' => true,
                        'file' => false,
                        'status_sub_konten' => true,
                        'status_sub_judul_section' => true,
                        'status_sub_deskripsi_section' => true,
                        'status_sub_judul' => true,
                        'status_sub_deskripsi' => true,
                        'status_sub_gambar' => true,
                        'status_sub_gambar_note' => 'Please insert image with 1x1 ratio for optimal looks',
                        'status_sub_gambar_deskripsi' => true,
                    )
				),
//                'free_trial' => array(
//                    'label' => 'Free Trial',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'free_trial_page' => array(
//                            'label' => 'Popup Free Trial',
//                            'route' => base_url('proweb/pages/type/free_trial'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'free_trial_list' => array(
//                            'label' => 'Data Request Free Trial',
//                            'route' => base_url('proweb/free_trial_request'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
//                'services' => array(
//                    'label' => 'Services List',
//                    'route' => base_url('proweb/tour'),
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array()
//                ),
//                'services' => array(
//                    'label' => 'Services',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//						'services_page' => array(
//							'label' => 'Services Page',
//							'route' => base_url('proweb/pages/type/services'),
//							'icon' => 'fab fa-asymmetrik'
//						),
//                        'categories' => array(
//                            'label' => 'Halaman Layanan Kami',
//                            'route' => base_url('proweb/pages/type/services'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'services' => array(
//                            'label' => 'Services List',
//                            'route' => base_url('proweb/tour'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'services_gallery' => array(
//                            'label' => 'Services Gallery List',
//                            'route' => base_url('proweb/tour_gallery'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
                'faq' => array(
                    'label' => 'FAQ',
                    'route' => base_url('proweb/pages/type/faq'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array(),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => false,
                        'description' => true,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => true,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => true,
                        'status_sub_deskripsi' => true,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_deskripsi' => false,
                    )
                ),
				'cart' => array(
					'label' => 'Cart Page',
					'route' => base_url('proweb/pages/type/cart'),
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array(),
                    'form_input' => array(
                        'judul_top_menu' => true,
                        'judul_halaman' => true,
                        'sub_judul' => false,
                        'description' => true,
                        'thumbnail' => false,
                        'file' => false,
                        'status_sub_konten' => true,
                        'status_sub_judul_section' => false,
                        'status_sub_deskripsi_section' => false,
                        'status_sub_judul' => true,
                        'status_sub_deskripsi' => true,
                        'status_sub_gambar' => false,
                        'status_sub_gambar_deskripsi' => false,
                    )
				),
				'delivery_coverage' => array(
					'label' => 'Delivery Coverage',
					'route' => base_url('proweb/delivery_coverage'),
					'icon' => 'fab fa-asymmetrik',
					'sub_menu' => array()
				),
//                'testimonial' => array(
//                    'label' => 'Testimonial',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'testimonial_page' => array(
//                            'label' => 'Testimonial Page',
//                            'route' => base_url('proweb/pages/type/testimonial'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'testimonial_list' => array(
//                            'label' => 'Testimonial List',
//                            'route' => base_url('proweb/testimonial'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
//                'gallery_photo' => array(
//                    'label' => 'Galeri Foto',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'gallery_photo_page' => array(
//                            'label' => 'Halaman Galeri Foto',
//                            'route' => base_url('proweb/pages/type/gallery_photo'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'gallery_photo_list' => array(
//                            'label' => 'Daftar Galeri Foto',
//                            'route' => base_url('proweb/gallery_photo'),
//                            'icon' => 'fab fa-asymmetrik'
//
//                        ),
//                    )
//                ),
//				'gallery_video' => array(
//					'label' => 'Gallery Video',
//					'route' => 'javascript:;',
//					'icon' => 'fab fa-asymmetrik',
//					'sub_menu' => array(
//						'gallery_photo_page' => array(
//							'label' => 'Gallery Video Page',
//							'route' => base_url('proweb/pages/type/gallery_video'),
//							'icon' => 'fab fa-asymmetrik'
//						),
//						'gallery_photo_list' => array(
//							'label' => 'Gallery Video List',
//							'route' => base_url('proweb/gallery_video'),
//							'icon' => 'fab fa-asymmetrik'
//
//						),
//					)
//				),

//                'price_list' => array(
//                    'label' => 'Daftar Harga',
//                    'route' => base_url('proweb/pages/type/price_list'),
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array()
//                ),
//                'reservation' => array(
//                    'label' => 'Reservation',
//                    'route' => 'javascript:;',
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array(
//                        'reservation_page' => array(
//                            'label' => 'Reservation Page',
//                            'route' => base_url('proweb/pages/type/reservation'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                        'reservation_list' => array(
//                            'label' => 'Reservation List',
//                            'route' => base_url('proweb/reservation'),
//                            'icon' => 'fab fa-asymmetrik'
//                        ),
//                    )
//                ),
//                'footer' => array(
//                    'label' => 'Footer Web',
//                    'route' => base_url('proweb/pages/type/footer'),
//                    'icon' => 'fab fa-asymmetrik',
//                    'sub_menu' => array()
//                ),
                'dictionary' => array(
                    'label' => 'Kamus Web',
                    'route' => base_url('proweb/dictionary'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
            ),
            'OTHERS MENU' => array(
                'email' => array(
                    'label' => 'Email',
                    'route' => base_url('proweb/email'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
                'file_manager' => array(
                    'label' => 'File Manager',
                    'route' => base_url('proweb/file_manager'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
                'language' => array(
                    'label' => 'Language',
                    'route' => base_url('proweb/language'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
                'admin' => array(
                    'label' => 'Manage Admin',
                    'route' => base_url('proweb/admin'),
                    'icon' => 'fab fa-asymmetrik',
                    'sub_menu' => array()
                ),
            ),
        );

        return $menu;
    }
}