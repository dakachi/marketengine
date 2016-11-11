<?php
class CSVExport {
    /**
     * Constructor
     */
    public function __construct() {
        if (isset($_GET['export']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'me-export')) {
            $csv = $this->generate_csv();

            if (empty($_GET['tab']) || $_GET['tab'] == 'listings') {
                $filename = __("Report Listings", "enginethemes");
            } else {
                switch ($_GET['tab']) {
                case 'orders':
                    $filename = __("Report Orders", "enginethemes");
                    break;
                case 'inquiries':
                    $filename = __("Report Inquiries", "enginethemes");
                    break;
                default:
                    $filename = __("Report Members", "enginethemes");
                    break;
                    break;
                }
            }

            if (!empty($_GET['from_date'])) {
                $filename .= '_' . $_GET['from_date'];
            }

            if (!empty($_GET['to_date'])) {
                $filename .= '_' . $_GET['to_date'];
            }

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"{$filename}.csv\";");
            header("Content-Transfer-Encoding: binary");

            echo $csv;
            exit;
        }
    }

    /**
     * Converting data to CSV
     */
    public function generate_csv() {
        if (empty($_GET['tab']) || $_GET['tab'] == 'listings') {
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

    /**
     * Generate CSV row
     * @param array $headings
     * @param array $data
     */
    public function generate_rows($headings, $data, $quant) {
        $csv_output = '';
        foreach ($headings as $key => $heading) {
            $csv_output = $csv_output . $heading . ',';
        }
        $csv_output .= "\n";

        foreach ($data as $key => $item) {
            foreach ($headings as $key => $heading) {
                if ($key == 'quant') {
                    $time = marketengine_get_start_and_end_date($quant, $item->quant, $item->year, 'Y/m/d');
                    $csv_output .= str_replace(',', '-', $time) . ",";
                } else {
                    $csv_output .= $item->$key . ",";
                }
            }
            $csv_output .= "\n";
        }
        return $csv_output;
    }

    public function generate_listings() {

        $args              = $_REQUEST;
        $args['showposts'] = 300000;
        $args['paged']     = 1;
        $query             = marketengine_listing_report($args);

        $quant          = empty($args['quant']) ? 'day' : $args['quant'];
        $active_section = empty($_REQUEST['section']) ? '' : $_REQUEST['section'];
        $listings       = $query['posts'];

        $csv_output = '';

        $csv_output = $csv_output . " Date,";

        if ($active_section == '') {
            $csv_output = $csv_output . " Total Listings,";
        }

        if ($active_section == '' || $active_section == 'purchase') {
            $csv_output = $csv_output . " Purchase,";
        }

        if ($active_section == '' || $active_section == 'contact') {
            $csv_output = $csv_output . " Contact,";
        }

        $csv_output .= "\n";

        foreach ($listings as $key => $listing) {
            $time = marketengine_get_start_and_end_date($quant, $listing->quant, $listing->year, 'Y/m/d');
            $csv_output .= str_replace(',', '-', $time) . ",";
            if ($active_section == '') {
                $csv_output .= $listing->count . ",";
            }
            if ($active_section == '' || $active_section == 'purchase') {
                $csv_output .= $listing->purchase_type . ",";
            }
            if ($active_section == '' || $active_section == 'contact') {
                $csv_output .= $listing->contact_type . ",";
            }

            $csv_output .= "\n";
        }
        return $csv_output;
    }

    public function generate_orders() {

        $args              = $_REQUEST;
        $args['showposts'] = 300000;
        $args['paged']     = 1;
        $query             = marketengine_orders_report($args);

        $quant = empty($args['quant']) ? 'day' : $args['quant'];

        $orders = $query['posts'];

        $headings = array(
            'quant' => __("Date", "enginethemes"),
            'count' => __("Total Orders", "enginethemes"),
            'total' => __("Income", "enginethemes") . '(' . me_option('payment-currency-sign') . ')',
        );

        return $this->generate_rows($headings, $orders, $quant);
    }

    public function generate_inquiries() {

        $args              = $_REQUEST;
        $args['showposts'] = 300000;
        $args['paged']     = 1;
        $query             = marketengine_inquiries_report($args);

        $quant = empty($args['quant']) ? 'day' : $args['quant'];

        $inquiries = $query['posts'];

        $headings = array(
            'quant' => __("Date", "enginethemes"),
            'count' => __("Total Inquiries", "enginethemes"),
        );

        return $this->generate_rows($headings, $inquiries, $quant);

    }

    public function generate_members() {

        $args              = $_REQUEST;
        $args['showposts'] = 300000;
        $args['paged']     = 1;
        $query             = marketengine_members_report($args);

        $quant = empty($args['quant']) ? 'day' : $args['quant'];

        $members = $query['posts'];

        $headings = array(
            'quant' => __("Registration Date", "enginethemes"),
            'count' => __("Total Members", "enginethemes"),
        );

        return $this->generate_rows($headings, $members, $quant);

    }

}
add_action('admin_init', 'me_export_reports');
function me_export_reports() {
    // Instantiate a singleton of this plugin
    $csvExport = new CSVExport();
}
