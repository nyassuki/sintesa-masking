<?php

namespace App\Database\Seeds\Development;

use CodeIgniter\Database\Seeder;

class MenuCategory extends Seeder
{
	public function run()
	{
		$data = [
			[
				'menu_category' 	=> 'Common Page'
			],
			[
				'menu_category' 	=> 'Settings'
			],
			[
				'menu_category' 	=> 'Developers'
			]
		];
		$this->db->table('user_menu_category')->insertBatch($data);
	}
}
