<?php
Class Productmodel extends CI_Model
{
    public function set_products($args){
		if(empty($args)){
			return FALSE;
		}
		
		if(!empty($args['url'])){
			$args['url'] = $this->db->escape_str($args['url']);
		}
		
		if(!empty($args['name'])){
			$args['name'] = $this->db->escape_str($args['name']);
		}
		
		if(!empty($args['price'])){
			$args['price'] = $this->db->escape_str($args['price']);
		}

		if(!empty($args['price_old'])){
			$args['price_old'] = $this->db->escape_str($args['price_old']);
		}
		
		if(!empty($args['description'])){
			$args['description'] = $this->db->escape_str($args['description']);
		}
		
		if (empty($args['id'])) {
			$args['created_at'] = date("Y-m-d H:i:s", time());		
			
            if ($this->db->insert('products', $args)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
			
            if ($this->db->where('id', (int)$args['id'])->update('products', $args)) {
                return $args['id'];
            } else {
                return FALSE;
            }
        }
	}

	public function set_product_images($args){
		if(empty($args)){
			return FALSE;
		}

		if(!empty($args['product_id']) && is_numeric($args['product_id'])){
			$args['product_id'] = (int)$args['product_id'];
		}
		
		if(!empty($args['image'])){
			$args['image'] = $this->db->escape_str($args['image']);
		}

		if (empty($args['id'])) {			
            if ($this->db->insert('product_images', $args)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
			
            if ($this->db->where('id', (int)$args['id'])->update('product_images', $args)) {
                return $args['id'];
            } else {
                return FALSE;
            }
        }
	}

	public function set_product_review($args){
		if(empty($args)){
			return FALSE;
		}

		if(!empty($args['product_id']) && is_numeric($args['product_id'])){
			$args['product_id'] = (int)$args['product_id'];
		}
		
		if(!empty($args['review'])){
			$args['review'] = $this->db->escape_str($args['review']);
		}

		if(!empty($args['like']) && is_numeric($args['like'])){
			$args['like'] = (int)$args['like'];
		}

		if(!empty($args['dislike']) && is_numeric($args['dislike'])){
			$args['dislike'] = (int)$args['dislike'];
		}

		if (empty($args['id'])) {
			$args['created_at'] = date("Y-m-d H:i:s", time());		
			
            if ($this->db->insert('product_review', $args)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
			
            if ($this->db->where('id', (int)$args['id'])->update('product_review', $args)) {
                return $args['id'];
            } else {
                return FALSE;
            }
        }
	}

	public function get_products()
	{
		$query = $this->db->get('products');
		return $query->result();
	}

	public function get_detail_product($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('products');
		return $query->row_array();
	}

	public function get_product_image($product_id)
	{
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('product_images');
		return $query->result_array();
	}

	public function get_product_review($product_id)
	{
		$this->db->where('product_id',$product_id);
		$query = $this->db->get('product_review');
		return $query->result_array();
	}

	public function get_detail_review($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('product_review');
		return $query->row_array();
	}

	public function delete_image($product_id)
	{
		$this->db->where('product_id',$product_id);
		return $this->db->delete('product_images');
	}
}

?>
