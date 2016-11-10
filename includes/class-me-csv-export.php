<?php
class ME_CSV_Export extends CSVExport {
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
		// $args['paged'] = 1;
		$query = marketengine_orders_report($args);

		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$orders = $query['posts'];

		$headings = array(
			'quant' => __("Date", "enginethemes"),
			'count' => __("Total Orders", "enginethemes"),
			'total' => __("Income", "enginethemes") . '(' . me_option('payment-currency-sign') . ')'
		);

		return $this->generate_rows($headings, $orders, $quant);
	}

	public function generate_transactions() {

		$args = $_REQUEST;
		$args['showposts'] = 300000;
		$args['paged'] = 1;
		$query = marketengine_inquiries_report($args);

		$quant = empty($args['quant']) ? 'day' : $args['quant'];

		$inquiries = $query['posts'];

		$headings = array(
			'quant' => __("Date", "enginethemes"),
			'count' => __("Total Inquiries", "enginethemes")
		);

		return $this->generate_rows($headings, $inquiries, $quant);

	}

}
add_action( 'init', 'me_export_reports_init' );
function me_export_reports_init() {
	// Instantiate a singleton of this plugin
	$csvExport = new ME_CSV_Export();
}
