<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//session_start(); //we need to call PHP's session object to access it through CI
class Test extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productmodel','',TRUE);
    }

    public function index()
    {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $this->load->view('header', $data);
        $this->load->view('topbar', $session_data);
        $this->load->view('sidebar', $session_data);

        $this->load->view('test_crawl',$data);
    }

    public function crawling()
    {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $this->load->view('header', $data);
        $this->load->view('topbar', $session_data);
        $this->load->view('sidebar', $session_data);

        $this->load->view('test_crawl',$data);
    }

    public function action_test_crawl()
    {
        $time_start = microtime(true);
        $url = $_POST['url'];

        $parse = parse_url($url);
        $host = $parse['host'];

        $dom = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true); //This is to prevent displaying error and put in log only
        $dom->loadHTMLfile($url);
        libxml_use_internal_errors($internalErrors); //This is to prevent displaying error
        $countlink = 0;
        $insertlink = 0;

        if($id = $this->productmodel->set_products(array(
          'url' => $url
        ))) {
          //get name
          $xpath = new DOMXPath($dom);
          $tags = $xpath->query('//span[@class="base"]');
          foreach ($tags as $tag) {
              $node_value = trim($tag->nodeValue);
              //echo $node_value."<br/>";
              $this->productmodel->set_products(array(
                'id' => $id, 
                'name' => $node_value
              ));
          }

          //get price
          $xpath = new DOMXPath($dom);
          $tags = $xpath->query('//span[@class="price"]');
          foreach ($tags as $key => $tag) {
              $node_value = trim($tag->nodeValue);
              if($key == 0){
                //echo $node_value."<br/>";
                $this->productmodel->set_products(array(
                  'id' => $id, 
                  'price' => $node_value
                ));
              }

              if($key == 1){
                //echo $node_value."<br/>";
                $this->productmodel->set_products(array(
                  'id' => $id, 
                  'price_old' => $node_value
                ));
              }              
          }

          //get desc
          $xpath = new DOMXPath($dom);
          $tags = $xpath->query('//div[@id="description"]');
          foreach ($tags as $tag) {
              $node_value = trim($tag->nodeValue);
              //echo $node_value."<br/>";
              $this->productmodel->set_products(array(
                'id' => $id, 
                'description' => $node_value
              ));
          }

          //get image   
          $elements = $dom->getElementsByTagName('script');
          $ppp = array();
          foreach ($elements as $key => $el) {
            $value = $el->getAttribute('type');
            if($value == 'text/x-magento-init'){
              $vals = json_decode(($el->nodeValue), true);
              $ppp[] = $vals;
            } 
          }
          $rrr = [];
          foreach ($ppp as $key => $value) {
            if(!empty($value['[data-gallery-role=gallery-placeholder]']))
            {
              echo '<pre>';
              $rrr = $value['[data-gallery-role=gallery-placeholder]'];
              if(!empty($rrr['mage/gallery/gallery']))
              {
                foreach ($rrr['mage/gallery/gallery']['data'] as $key => $value) 
                {
                  //echo $value['img'].'<br>';
                  $this->productmodel->set_product_images(array(
                    'product_id' => $id, 
                    'image' => $value['img']
                  ));
                }
              }
            }
          } 

          //get a href
          /*
          foreach ($dom->getElementsByTagName('a') as $node) {
              $link = $node->getAttribute('href');
              if ((strpos($link, $host) !== false) or (preg_match('/\/.+/', $link))) {
                if (preg_match('/^\/.+/', $link)) {
                    $link='http://'.$host.$link;
                }

                echo $link."<br>";
                ++$countlink;
              }
          }
          echo 'Total link found in this page: '.$countlink.'<br>';          
          */
          echo '<br>Total execution time in seconds: '.(microtime(true) - $time_start);
          
          redirect('test/product/'.$id);
        }else{

        }
    }

    public function product($id)
    {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $this->load->view('header', $data);
        $this->load->view('topbar', $session_data);
        $this->load->view('sidebar', $session_data);

        $data['detail'] = $this->productmodel->get_detail_product($id);
        $data['images'] = $this->productmodel->get_product_image($id);
        $data['reviews'] = $this->productmodel->get_product_review($id);        
        
        $this->load->view('product_detail',$data);
    }

    public function review()
    {
      $product_id = $_POST['product_id'];
      $review = $_POST['review'];

      $this->productmodel->set_product_review(array(
        'product_id' => $product_id, 
        'review' => $review
      ));

      redirect('test/product/'.$product_id);
    }

    public function like($product_id,$id)
    {
      $rev = $this->productmodel->get_detail_review($id);
      $like = 1;
      if($rev['like'] > 0){
        $like = (int)$rev['like']+(int)1;
      }

      $this->productmodel->set_product_review(array(
        'id' => $id, 
        'like' => $like
      ));

      redirect('test/product/'.$product_id);
    }

    public function dislike($product_id, $id)
    {
      $rev = $this->productmodel->get_detail_review($id);

      $dislike = 1;
      if($rev['dislike'] > 0){
        $dislike = (int)$rev['dislike']+(int)1;
      }

      $this->productmodel->set_product_review(array(
        'id' => $id, 
        'dislike' => $dislike
      ));

      redirect('test/product/'.$product_id);
    }

    public function cron() 
    {
      $time_start = microtime(true);

      $data['products'] = $this->productmodel->get_products();

      $count = 0;
      foreach ($data['products'] as $key => $prod) {
        $url = $prod->url;
        $id = $prod->id;

        $dom = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true); //This is to prevent displaying error and put in log only
        $dom->loadHTMLfile($url);
        libxml_use_internal_errors($internalErrors); //This is to prevent displaying error
        $countlink = 0;
        $insertlink = 0;

        //get name
        $xpath = new DOMXPath($dom);
        $tags = $xpath->query('//span[@class="base"]');
        foreach ($tags as $tag) {
            $node_value = trim($tag->nodeValue);
            //echo $node_value."<br/>";
            $this->productmodel->set_products(array(
              'id' => $id, 
              'name' => $node_value
            ));
        }

        //get price
        $xpath = new DOMXPath($dom);
        $tags = $xpath->query('//span[@class="price"]');
        foreach ($tags as $key => $tag) {
            $node_value = trim($tag->nodeValue);
            if($key == 0){
              //echo $node_value."<br/>";
              $this->productmodel->set_products(array(
                'id' => $id, 
                'price' => $node_value
              ));
            }

            if($key == 1){
              //echo $node_value."<br/>";
              $this->productmodel->set_products(array(
                'id' => $id, 
                'price_old' => $node_value
              ));
            }              
        }

        //get desc
        $xpath = new DOMXPath($dom);
        $tags = $xpath->query('//div[@id="description"]');
        foreach ($tags as $tag) {
            $node_value = trim($tag->nodeValue);
            //echo $node_value."<br/>";
            $this->productmodel->set_products(array(
              'id' => $id, 
              'description' => $node_value
            ));
        }

        //get image   
        $this->productmodel->delete_image($id);

        $elements = $dom->getElementsByTagName('script');
        $ppp = array();
        foreach ($elements as $key => $el) {
          $value = $el->getAttribute('type');
          if($value == 'text/x-magento-init'){
            $vals = json_decode(($el->nodeValue), true);
            $ppp[] = $vals;
          } 
        }
        $rrr = [];
        foreach ($ppp as $key => $value) {
          if(!empty($value['[data-gallery-role=gallery-placeholder]']))
          {
            echo '<pre>';
            $rrr = $value['[data-gallery-role=gallery-placeholder]'];
            if(!empty($rrr['mage/gallery/gallery']))
            {
              foreach ($rrr['mage/gallery/gallery']['data'] as $key => $value) 
              {
                //echo $value['img'].'<br>';
                $this->productmodel->set_product_images(array(
                  'product_id' => $id, 
                  'image' => $value['img']
                ));
              }
            }
          }
        } 
        $count++;
      }
      
      echo '<br>Total execution time in seconds: '.(microtime(true) - $time_start);
      echo '<br>Total execution products url: '.$count;
    }

}
