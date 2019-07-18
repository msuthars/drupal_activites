<?php

namespace Drupal\hoa\Services\Form;

/**
 * Form Data Manager Interface.
 */
interface FormDataManagerInterface {
	
	/**
	 * List of indian states.
	 */
	const INDIAN_STATE = [
		'AR' => 'Arunachal Pradesh',
		'AR' => 'Arunachal Pradesh',
		'AS' => 'Assam',
		'BR' => 'Bihar',
		'CT' => 'Chhattisgarh',
		'GA' => 'Goa',
		'GJ' => 'Gujarat',
		'HR' => 'Haryana',
		'HP' => 'Himachal Pradesh',
		'JK' => 'Jammu and Kashmir',
		'JH' => 'Jharkhand',
		'KA' => 'Karnataka',
		'KL' => 'Kerala',
		'MP' => 'Madhya Pradesh',
		'MH' => 'Maharashtra',
		'MN' => 'Manipur',
		'ML' => 'Meghalaya',
		'MZ' => 'Mizoram',
		'NL' => 'Nagaland',
		'OR' => 'Odisha',
		'PB' => 'Punjab',
		'RJ' => 'Rajasthan',
		'SK' => 'Sikkim',
		'TN' => 'Tamil Nadu',
		'TG' => 'Telangana',
		'TR' => 'Tripura',
		'UP' => 'Uttar Pradesh',
		'UT' => 'Uttarakhand',
		'WB' => 'West Bengal',
		'AN' => 'Andaman and Nicobar Islands',
		'CH' => 'Chandigarh',
		'DN' => 'Dadra and Nagar Haveli',
		'DD' => 'Daman and Diu',
		'LD' => 'Lakshadweep',
		'DL' => 'National Capital Territory of Delhi',
		'PY' => 'Puducherry'
	];

	/**
	 * List of UK Counties.
	 */
	const UK_COUNTIES = [
		'Aberdeenshire' => 'Aberdeenshire',
		'Angus' => 'Angus',
		'Antrim' => 'Antrim',
		'Argyll' => 'Argyll',
		'Armagh' => 'Armagh',
		'Ayrshire' => 'Ayrshire',
		'Banffshire' => 'Banffshire',
		'Bedfordshire' => 'Bedfordshire',
		'Berkshire' => 'Berkshire',
		'Berwickshire' => 'Berwickshire',
		'Bristol' => 'Bristol',
		'Buckinghamshire' => 'Buckinghamshire',
		'Bute' => 'Bute',
		'Caithness' => 'Caithness',
		'Cambridgeshire' => 'Cambridgeshire',
		'Cheshire' => 'Cheshire',
		'City of London' => 'City of London',
		'Clackmannanshire' => 'Clackmannanshire',
		'Clwyd' => 'Clwyd',
		'Cornwall' => 'Cornwall',
		'Cumbria' => 'Cumbria',
		'Derbyshire' => 'Derbyshire',
		'Devon' => 'Devon',
		'Dorset' => 'Dorset',
		'Down' => 'Down',
		'Dumfriesshire' => 'Dumfriesshire',
		'Dunbartonshire' => 'Dunbartonshire',
		'Durham' => 'Durham',
		'Dyfed' => 'Dyfed',
		'East Lothian' => 'East Lothian',
		'East Riding of Yorkshire' => 'East Riding of Yorkshire',
		'East Sussex' => 'East Sussex',
		'Essex' => 'Essex',
		'Fermanagh' => 'Fermanagh',
		'Fife' => 'Fife',
		'Gloucestershire' => 'Gloucestershire',
		'Greater London' => 'Greater London',
		'Greater Manchester' => 'Greater Manchester',
		'Gwent' => 'Gwent',
		'Gwynedd' => 'Gwynedd',
		'Hampshire' => 'Hampshire',
		'Herefordshire' => 'Herefordshire',
		'Hertfordshire' => 'Hertfordshire',
		'Inverness-shire' => 'Inverness-shire',
		'Isle of Wight' => 'Isle of Wight',
		'Kent' => 'Kent',
		'Kincardineshire' => 'Kincardineshire',
		'Kinross-shire' => 'Kinross-shire',
		'Kirkcudbrightshire' => 'Kirkcudbrightshire',
		'Lanarkshire' => 'Lanarkshire',
		'Lancashire' => 'Lancashire',
		'Leicestershire' => 'Leicestershire',
		'Lincolnshire' => 'Lincolnshire',
		'Londonderry' => 'Londonderry',
		'Merseyside' => 'Merseyside',
		'Mid Glamorgan' => 'Mid Glamorgan',
		'Midlothian' => 'Midlothian',
		'Moray' => 'Moray',
		'Nairnshire' => 'Nairnshire',
		'Norfolk' => 'Norfolk',
		'North Yorkshire' => 'North Yorkshire',
		'Northamptonshire' => 'Northamptonshire',
		'Northumberland' => 'Northumberland',
		'Nottinghamshire' => 'Nottinghamshire',
		'Orkney' => 'Orkney',
		'Oxfordshire' => 'Oxfordshire',
		'Peeblesshire' => 'Peeblesshire',
		'Perthshire' => 'Perthshire',
		'Powys' => 'Powys',
		'Renfrewshire' => 'Renfrewshire',
		'Ross and Cromarty' => 'Ross and Cromarty',
		'Roxburghshire' => 'Roxburghshire',
		'Rutland' => 'Rutland',
		'Selkirkshire' => 'Selkirkshire',
		'Shetland' => 'Shetland',
		'Shropshire' => 'Shropshire',
		'Somerset' => 'Somerset',
		'South Glamorgan' => 'South Glamorgan',
		'South Yorkshire' => 'South Yorkshire',
		'Staffordshire' => 'Staffordshire',
		'Stirlingshire' => 'Stirlingshire',
		'Suffolk' => 'Suffolk',
		'Surrey' => 'Surrey',
		'Sutherland' => 'Sutherland',
		'Tyne and Wear' => 'Tyne and Wear',
		'Tyrone' => 'Tyrone',
		'Warwickshire' => 'Warwickshire',
		'West Glamorgan' => 'West Glamorgan',
		'West Lothian' => 'West Lothian',
		'West Midlands' => 'West Midlands',
		'West Sussex' => 'West Sussex',
		'West Yorkshire' => 'West Yorkshire',
		'Wigtownshire' => 'Wigtownshire',
		'Wiltshire' => 'Wiltshire',
		'Worcestershire' => 'Worcestershire',
	];
	
	/**
	 * Get Last Submitted data of DIC Form.
	 * 
	 * @return array
	 *   Last submitted data.
	 */
	public function getDicFormData();

	/**
	 * Save DIC form data.
	 * 
	 * @param array $data
	 *   User submitted (first name, last name) data.
	 */
	public function setDicFormData($data);

}