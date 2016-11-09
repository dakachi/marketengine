<?php 
class CSVExport
{
	/**
	* Constructor
	*/
	public function __construct()
	{
		if(isset($_GET['export']) && isset($_GET['_wpnonce']) && wp_verify_nonce( $_GET['_wpnonce'], 'me-export' ))
		{
			$csv = $this->generate_csv();

			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"report.csv\";" );
			header("Content-Transfer-Encoding: binary");

			echo $csv;
			exit;
		}
	}

	/**
	* Converting data to CSV
	*/
	public function generate_csv()
	{
		if(empty($_GET['tab']) || $_GET['tab'] == 'listings') {
			return $this->generate_listings();
		}

		switch ($_GET['tab']) {
			case 'orders':
				return $this->generate_orders();
				break;
			case 'inquiries':
				return $this->generate_inquiries();
				break;
			default:
				return $this->generate_members();
				break;
		}

	}

	public function generate_listings() {
		$csv_output = '';
		
		$csv_output = $csv_output ." Date,";
		$csv_output = $csv_output ." Total Listings,";
		$csv_output = $csv_output ." Contact,";
		$csv_output = $csv_output ." Purchase,";
		$csv_output .= "\n";

		$args = $_REQUEST;
		$args['showposts'] = 300000;
		$query = marketengine_listing_report($args);
		
		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$listings = $query['posts'];

		foreach ($listings as $key => $listing) {
			$time = marketengine_get_start_and_end_date($quant, $listing->quant, $listing->year);
			$csv_output .= str_replace( ',', '-', $time).",";
			$csv_output .= $listing->count.",";
			$csv_output .= $listing->purchase_type.",";
			$csv_output .= $listing->contact_type.",";	
			$csv_output .= "\n";
		}
		return $csv_output;
	}

	public function generate_orders() {
		$csv_output = '';
		
		$csv_output = $csv_output ." Date,";
		$csv_output = $csv_output ." Total Orders,";
		$csv_output = $csv_output ." Income,";
		$csv_output .= "\n";

		$args = $_REQUEST;
		$args['showposts'] = 300000;
		$query = marketengine_orders_report($args);
		
		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$orders = $query['posts'];

		foreach ($orders as $key => $order) {
			$time = marketengine_get_start_and_end_date($quant, $order->quant, $order->year);
			$csv_output .= str_replace( ',', '-', $time).",";
			$csv_output .= $order->count.",";
			$csv_output .= $order->total.",";
			$csv_output .= "\n";
		}
		return $csv_output;
	}

	public function generate_inquiries() {
		$csv_output = '';
		
		$csv_output = $csv_output ." Date,";
		$csv_output = $csv_output ." Total Inquiries,";
		$csv_output .= "\n";

		$args = $_REQUEST;
		$args['showposts'] = 300000;
		$query = marketengine_inquiries_report($args);
		
		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$inquiries = $query['posts'];

		foreach ($inquiries as $key => $inquiry) {
			$time = marketengine_get_start_and_end_date($quant, $inquiry->quant, $inquiry->year);
			$csv_output .= str_replace( ',', '-', $time).",";
			$csv_output .= $inquiry->count.",";
			$csv_output .= "\n";
		}
		return $csv_output;
	}

	public function generate_members() {
		$csv_output = '';
		
		$csv_output = $csv_output ." Date,";
		$csv_output = $csv_output ." Total Members,";
		$csv_output .= "\n";

		$args = $_REQUEST;
		$args['showposts'] = 300000;
		$query = marketengine_members_report($args);
		
		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$members = $query['posts'];

		foreach ($members as $key => $member) {
			$time = marketengine_get_start_and_end_date($quant, $member->quant, $member->year);
			$csv_output .= str_replace( ',', '-', $time).",";
			$csv_output .= $member->count.",";
			$csv_output .= "\n";
		}
		return $csv_output;
	}

}
add_action( 'admin_init', 'me_export_reports' );
function me_export_reports() {
	// Instantiate a singleton of this plugin
	$csvExport = new CSVExport();	
}
