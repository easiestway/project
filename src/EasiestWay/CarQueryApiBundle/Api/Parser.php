<?php
/**
 * Created by PhpStorm.
 * @author d.shokel@gmail.com
 */

namespace EasiestWay\CarQueryApiBundle\Api;


class Parser
{
    protected $apiUrl = 'http://www.carqueryapi.com/api/0.3/?cmd=';

    /**
     * Retrieve data from the CarQueryAPI url
     *
     * @param string  $cmd
     * @param array   $params
     * @param integer $retry
     *
     * @return array|boolean false on failure
     */
    protected function getData($cmd, array $params = array(), $retry = 5) {
        $apiUrl = $this->apiUrl . $cmd;
        foreach ($params as $key => $value) {
            $apiUrl .= "&{$key}={$value}";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);

        $raw = curl_exec($ch);
        $err = curl_errno($ch);
        curl_close($ch);
        if ($err > 0 || null === ($decodedResult = json_decode($raw, true))) {
            if ($retry > 0) {
                return $this->getData($cmd, $params, ($retry - 1));
            }
            return false;
        }
        return $decodedResult;
    }

    /**
     * Retrieve range of available years from the CarQuery database.
     *
     * @return array(
     *     'min_year' => 'YYYY',
     *     'max_year' => 'YYYY',
     * )
     */
    public function getYears()
    {
        $return = $this->getData(__FUNCTION__);
        return $return['Years'];
    }

    /**
     * Retrieve all makes which produced a model in the specified year
     *
     * @param integer $year
     * @param boolean $soldInUs parameter is optional. Setting it to true will
     * restrict results to models sold in the USA.
     *
     * @return array(
     *     array(
     *         'make_id'        => 'ford',
     *         'make_display'   => 'Ford',
     *         'make_is_common' => 0,
     *         'make_country'   => 'US',
     *     ),
     *     array(
     *         'make_id'        => 'ford',
     *         'make_display'   => 'Ford',
     *         'make_is_common' => 0,
     *         'make_country'   => 'US',
     *     ),
     *     ...
     */
    public function getMakes($year, $soldInUS = false)
    {
        $params = array('year' => $year);
        if ($soldInUS) {
            $params['sold_in_ud'] = '1';
        }
        $return = $this->getData(__FUNCTION__, $params);
        return $return['Makes'];
    }

    /**
     * Retrieve all model names produced by the specified manufacturer in the
     * specified year.
     *
     * @param string  $makeId
     * @param integer $year     parameter is optional. Omitting it will retrieve
     * all model names ever produced by the manufacturer.
     * @param boolean $soldInUs parameter is optional. Setting it to true will
     * restrict results to models sold in the USA.
     * @param string  $body     parameter is optional. Including it will restrict
     * results to models of the specified body type (SUV, Sedan, etc)
     *
     * @return array(
     *     array(
     *         'model_name'    => 'Escape',
     *         'model_make_id' => 'ford'
     *     ),
     *     array(
     *         'model_name'    => 'Excursion',
     *         'model_make_id' => 'ford'
     *     ),
     *     ...
     * )
     */
    public function getModels($makeId, $year = null, $soldInUs = false, $body = null)
    {
        $params = array('make' => $makeId);
        if (null !== $year) {
            $params['year'] = $year;
        }
        if ($soldInUs) {
            $params['sold_in_ud'] = '1';
        }
        if (null !== $body) {
            $params['body'] = $body;
        }
        $return = $this->getData(
            __FUNCTION__,
            array(
                'make' => $makeId,
            )
        );
        return $return['Models'];
    }

    /**
     * Retrieve trim data for models meeting specified criteria.
     *
     * @param array $params All parameters to getTrims are optional.
     * You may include any of the keys in the return values.
     *
     * @return array(
     *     array(
     *         'model_id'      => '15155,
     *         'model_make_id' => 'ford,
     *         'model_name'    => 'Taurus',
     *         'model_trim'    => '',
     *         'model_year'    => '2000',
     *         ...(all available model fields are included)
     *     ),
     *     array(
     *         'model_id'      => '15155,
     *         'model_make_id' => 'ford,
     *         'model_name'    => 'Taurus',
     *         'model_trim'    => '',
     *         'model_year'    => '2000',
     *         ...(all available model fields are included)
     *     ),
     *     ...
     * )
     */
    public function getTrims(array $params = array())
    {
        $return = $this->getData(
            __FUNCTION__,
            $params
        );
        return $return['Trims'];
    }

    /**
     * Retrieve all available data on the specified model.
     *
     * @param integer $modelId A model id retrieved through getTrims
     *
     * @return array(
     *     'model_id' => '11459',
     *     'model_make_id' => 'dodge',
     *     'model_name' => 'Viper SRT10',
     *     'model_year' => '2009',
     *     'model_body' => 'Roadster',
     *     'model_engine_position' => 'Front',
     *     'model_engine_cc' => '8285',
     *     'model_engine_cyl' => '10',
     *     'model_engine_type' => 'V',
     *     'model_engine_valves_per_cyl' => '2',
     *     'model_engine_power_ps' => '506',
     *     'model_engine_power_rpm' => '5600',
     *     'model_engine_torque_nm' => '711',
     *     'model_engine_torque_rpm' => '4200',
     *     'model_engine_bore_mm' => '102.4',
     *     'model_engine_stroke_mm' => '100.6',
     *     'model_engine_compression' => '10.0:1',
     *     'model_engine_fuel' => 'Gasoline - unleaded 95',
     *     'model_top_speed_kph' => '314',
     *     'model_0_to_100_kph' => '3.9',
     *     'model_drive' => 'Rear',
     *     'model_transmission_type' => 'Manual',
     *     'model_seats' => '2',
     *     'model_doors' => '2',
     *     'model_weight_kg' => '1602',
     *     'model_length_mm' => '4470',
     *     'model_width_mm' => '1950',
     *     'model_height_mm' => '1220',
     *     'model_wheelbase_mm' => '2520',
     *     'model_lkm_hwy' => '11',
     *     'model_lkm_mixed' => '21',
     *     'model_lkm_city' => '18',
     *     'model_fuel_cap_l' => '70',
     *     'model_sold_in_us' => '1',
     *     'model_engine_l' => '8.3',
     *     'model_engine_ci' => '506',
     *     'model_engine_valves' => '20',
     *     'model_engine_power_hp' => '499',
     *     'model_engine_power_kw' => '372',
     *     'model_engine_torque_lbft' => '524',
     *     'model_engine_torque_kgm' => '73',
     *     'model_top_speed_mph' => '195',
     *     'model_weight_lbs' => '3532',
     *     'model_length_in' => '176.0',
     *     'model_width_in' => '76.8',
     *     'model_height_in' => '48.0',
     *     'model_wheelbase_in' => '99.2',
     *     'model_mpg_hwy' => '21',
     *     'model_mpg_city' => '13',
     *     'model_mpg_mixed' => '11',
     *     'model_fuel_cap_g' => '18.5',
     *     'make_display' => 'Dodge',
     *     'make_country' => 'USA',
     *     'ExtColors' => array(),  //Note, Color options are only available for select vehicles.
     *     'IntColors' => array()
     * )
     */
    public function getModel($modelId)
    {
        $return = $this->getData(
            __FUNCTION__,
            array(
                'model' => $modelId,
            )
        );
        return $return[0];
    }
} 