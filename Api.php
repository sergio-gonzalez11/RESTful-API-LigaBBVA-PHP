
<?php

/**
 *
 * @author Sergio González Ruano
 * @date 24.10.2019 | switched to v2 09.08.2018
 * 
 */

 class Api {
    
    public $config;
    public $url;
    public $request = array();
        
    public function __construct() {
        $this->config = parse_ini_file('config.ini', true);

	// some lame hint for the impatient
	if($this->config['authToken'] == 'YOUR_AUTH_TOKEN' || !isset($this->config['authToken'])) {
		exit('Get your API-Key first and edit config.ini');
	}
        
        $this->url = $this->config['url']; 
        
        $this->request['http']['method'] = 'GET';
        $this->request['http']['header'] = 'X-Auth-Token: ' . $this->config['authToken'];
    }

    
    /**
     * Function returns a particular competition identified by an id.
     * 
     * @param Integer $id
     * @return array
     */        
    public function buscarCompeticionPorId($id) {
        $resource = 'competitions/' . $id;
        $response = file_get_contents($this->url . $resource, false, 
                                      stream_context_create($this->request));
        
        return json_decode($response);
    }
    

    /**
     * Function returns all available matches for a given date range.
     * 
     * @param DateString 'Y-m-d' $start
     * @param DateString 'Y-m-d' $end
     * 
     * @return array of matches
     */    
    public function buscarPartidosPorFecha($start, $end) {
        $resource = 'matches/?dateFrom=' . $start . '&dateTo=' . $end;

        $response = file_get_contents($this->url . $resource, false, 
                                      stream_context_create($this->request));
        
        return json_decode($response);
    }
    
    public function buscarPartidosAnterioresJornadaActual($c, $m) {
        $resource = 'competitions/' . $c . '/matches/?matchday=' . $m;

        $response = file_get_contents($this->url . $resource, false, 
                                      stream_context_create($this->request));
        
        return json_decode($response);
    }

    public function clasificacionGeneral($id) {
	$resource = 'competitions/' . $id . '/standings';
        $response = file_get_contents($this->url . $resource, false, 
                                      stream_context_create($this->request));

        return json_decode($response);
    }

}
