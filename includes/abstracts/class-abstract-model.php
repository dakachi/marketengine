<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Abstract Model Class
 *
 * MarketEngine Model Class extend to working with database object
 * @class       AE_Model
 * @version     1.0
 * @package     marketengine/abstracts
 * @author      Dakachi
 * @category    Abstract Class
 */
abstract class AE_Model {
    static $primary_key = 'id';
    private static function _table() {
        global $wpdb;
        $tablename = strtolower( get_called_class() );
        $tablename = str_replace( 'wpas_model_', 'wpas_', $tablename );
        return $wpdb->prefix . $tablename;
    }
    
    private static function _fetch_sql( $value ) {
        global $wpdb;
        $sql = sprintf( 'SELECT * FROM %s WHERE %s = %%s', self::_table(), static::$primary_key );
        return $wpdb->prepare( $sql, $value );
    }
    static function get( $value ) {
        global $wpdb;
        return $wpdb->get_row( self::_fetch_sql( $value ) );
    }
    static function insert( $data ) {
        global $wpdb;
        $wpdb->insert( self::_table(), $data );
    }
    static function update( $data, $where ) {
        global $wpdb;
        $wpdb->update( self::_table(), $data, $where );
    }
    static function delete( $value ) {
        global $wpdb;
        $sql = sprintf( 'DELETE FROM %s WHERE %s = %%s', self::_table(), static::$primary_key );
        return $wpdb->query( $wpdb->prepare( $sql, $value ) );
    }
    static function insert_id() {
        global $wpdb;
        return $wpdb->insert_id;
    }
    static function time_to_date( $time ) {
        return gmdate( 'Y-m-d H:i:s', $time );
    }
    static function now() {
        return self::time_to_date( time() );
    }
    static function date_to_time( $date ) {
        return strtotime( $date . ' GMT' );
    }
}