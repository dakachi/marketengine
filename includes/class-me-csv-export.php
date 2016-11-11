<?php
class ME_CSV_Export {
	/**
	* Constructor
	*/
	public function __construct()
	{
		if(isset($_GET['export']) && isset($_GET['_wpnonce']) && wp_verify_nonce( $_GET['_wpnonce'], 'me-export_report' ))
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
		if(empty($_GET['tab']) || $_GET['tab'] == 'order') {
			return $this->generate_orders();
		}

		switch ($_GET['tab']) {
			case 'order':
				return $this->generate_orders();
				break;
			case 'transaction':
				return $this->generate_transactions();
				break;
		}

	}

	public function generate_orders() {

		$args = $_REQUEST;
		$args['showposts'] = -1;
		$data = me_order_report_data($args);

		$headings = array(
			'order_id' 		=> __("Order ID", "enginethemes"),
			'status' 		=> __("Status", "enginethemes"),
			'amount' 		=> __("Amount", "enginethemes"),
			'date_of_order'			=> __("Date Of Order", "enginethemes"),
			'listing_title'	=> __("Listing", "enginethemes"),
		);

		return $this->generate_rows($headings, $data);
	}

	public function generate_transactions() {
		$args = $_REQUEST;

		$data = me_transaction_report_data($args);

		$headings = array(
			'transaction_id'=> __("Transaction ID", "enginethemes"),
			'status' 		=> __("Status", "enginethemes"),
			'amount' 		=> __("Amount", "enginethemes"),
			'date_of_order'	=> __("Date Of Order", "enginethemes"),
			'listing_title'	=> __("Listing", "enginethemes"),
		);

		return $this->generate_rows($headings, $data);

	}

	/**
	 * Generate CSV row
	 * @param array $headings
	 * @param array $data
	 */
	public function generate_rows($headings, $data) {
		$csv_output = '';
		foreach ($headings as $key => $heading) {
			$csv_output = $csv_output . $heading . ',';
		}
		$csv_output .= "\n";

		foreach ($data as $key => $item) {
			foreach ($headings as $key => $heading) {
				$csv_output .= $key == 'transaction_id' ? '#' : '';
				if( $key == 'status') {
					$status_arr = me_get_order_status_list();
					$csv_output .= $status_arr[$item->$key] .",";
				} else {
					$csv_output .= $item->$key.",";
				}
			}
			$csv_output .= "\n";
		}
		return $csv_output;
	}

}
add_action( 'init', 'me_export_reports_init' );
function me_export_reports_init() {
	// Instantiate a singleton of this plugin
	$csvExport = new ME_CSV_Export();
}
