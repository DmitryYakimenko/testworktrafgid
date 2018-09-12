<?php



class IndexController extends Controller{
	
	

 
    public function indexAction(){
		
		//Init::redirect('/film/index');
    }

    public function queryAction($input = null){
        switch ($input['Params'][0]){
            case '1':
                $this->data['query'] = $this->query1();
                break;
            case '2':
                $this->data['query'] = $this->query2();
                break;
            default:
                $this->data['massage'] = 'неправильный параметр';
        }
        $this->data['keys'] = array_keys($this->data['query'][0]);
        //Init::redirect('/film/index');
    }

    private function query1(){
        $db = Init::getDb();
        $db->execute('SELECT requests.id, offers.name as offer_name, requests.price, requests.count, operators.name as operator_name FROM requests
JOIN offers on offers.id = requests.offer_id
JOIN operators on operators.id = requests.operator_id
WHERE ( requests.count > 2 ) AND (operators.id = 10 OR operators.id = 12)');
        $result = $db->getResult();
        return $result;
    }

    private function query2(){
        $db = Init::getDb();
        $db->execute('SELECT offers.name, SUM(requests.count) as count, SUM(requests.price) as sum FROM requests
JOIN offers on offers.id = requests.offer_id
GROUP BY requests.offer_id');
        $result = $db->getResult();
        return $result;
    }
}