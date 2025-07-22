<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Get_mongodb extends CI_Model {

	public $name;
	public $project;

	public function __construct() {
		parent::__construct();
	}

	function getAll()
	{
           // $query = $this->cimongo->collfindOne('users');
		   //$query = $this->cimongo->get_where('user', array($field => 'name'));
		   
           // $result = $query->num_rows();
            
            //return $result;
			//$str1 = "connection successfully";
			
			$query = $this->cimongo->get('users');
			$result = $query->result();
			return $result ;
	}

	function saveDocumentMetada($tenantid, $departmenid, $filearray, $documentinfoarr, $tempid, $type, $revision, $documentid, $templatename, $currDate, $usermailid, $isPrivate) {
		try {
			if ($filearray != null) {
				for ($fileindex = 0; $fileindex < count($filearray); $fileindex++) {
					$docext = $filearray[$fileindex];
					$docname = explode(".", $docext);
					$documentname = $docname[0];
					
					$documentdata = array(
						'TenantId' => (int)$tenantid,
						'DepartmentId' => (int)$departmenid,
						'DocumentName' => $documentname,
						'LatestRevision' => 0,
						'IsPrivate' => $isPrivate === 'true',
						'DocumentInfo' => array($documentinfoarr),
						'AuditData' => array(
							'DateAdded' => $currDate,
							'AddedBy' => $usermailid,
							'DateModified' => $currDate,
							'ModifiedBy' => $usermailid,
							'DeleteFlag' => false
						)
					);

					if ($tempid != '') {
						$documentdata['TemplateId'] = new MongoID($tempid);
					}

					if ($type == 'new') {
						$result = $this->cimongo->insert('DocumentMetaData', $documentdata);
						return $result ? 1 : 0;
					} else if ($type == 'revision') {
						$criteria = array('_id' => new MongoID($documentid));
						$result = $this->cimongo->push(array('DocumentInfo' => $documentinfoarr))
											  ->where($criteria)
											  ->update('DocumentMetaData');
						return $result ? 1 : 0;
					}
				}
			}
			return 0;
		} catch (Exception $e) {
			error_log("Error in saveDocumentMetada: " . $e->getMessage());
			return 0;
		}
	}

	function getTemplateslist($tenantid, $userdepartid, $collection = 'TemplateMetaData') {
		try {
			$selectTemp = array("_id", "HtmlFileName", "HtmlFileLocation", "TemplateHeader");
			$wheretenanttemp = $userdepartid != '' ? 
				array("TenantId" => $tenantid, "DepartmentId" => $userdepartid) :
				array("TenantId" => $tenantid);
			
			$templatequery = $this->cimongo->select($selectTemp)
										 ->where($wheretenanttemp)
										 ->get($collection);
			
			$tempresult = $templatequery->result_array();
			return $templatequery->num_rows() > 0 ? $tempresult : 0;
		} catch (Exception $e) {
			error_log("Error in getTemplateslist: " . $e->getMessage());
			return 0;
		}
	}

	function getTemplatelocation($tenantid, $tempname, $collection = "TemplateMetaData") {
		try {
			$criteria = array('TenantId' => $tenantid, 'HtmlFileName' => $tempname);
			$select = array('HtmlFileLocation');
			$query = $this->cimongo->select($select)
								 ->where($criteria)
								 ->get($collection);
			
			$result = $query->result_array();
			return $query->num_rows() > 0 ? $result : 0;
		} catch (Exception $e) {
			error_log("Error in getTemplatelocation: " . $e->getMessage());
			return 0;
		}
	}

	function documentrevisionData($tenantid, $userdepartid, $collection = 'DocumentMetaData') {
		try {
			$selectrevdata = array("DocumentInfo.RevisionNo");
			$whererevdata = array(
				"TenantId" => $tenantid,
				"DepartmentId" => $userdepartid
			);
			
			$docrevsionquery = $this->cimongo->select($selectrevdata)
										   ->order_by(array("DocumentInfo.RevisionNo" => 'DESC'))
										   ->limit(1)
										   ->where($whererevdata)
										   ->get($collection);
			
			return $docrevsionquery->result_array();
		} catch (Exception $e) {
			error_log("Error in documentrevisionData: " . $e->getMessage());
			return array();
		}
	}
}
?>