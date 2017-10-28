<?php

return [

    'bank_accounts' => [

        [
            'name'          => 'Souktrain',
            'bank'          => 'GTBank',
            'account_no'    => '00986789287'
        ]
    ],


	'beneficiaries'  =>[
		'souktrain' => [
			'ratio' => 0.7,
			'emails' => [
				'souktrain@gmail.com'
			],
		],
		'netronit' => [
			'ratio' => 0.3,
			'emails' => [
				'perspective@netronit.com',
				'crysto@netronit.com'
			],
		]
	]

];