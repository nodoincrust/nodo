 $wheredoc   = array("DocumentName" => $documentname); 
            $selectdoc  = array("DocumentInfo");
            $commentdocument = $this->cimongo->select($selectdoc)->where($wheredoc)->get('DocComment');
            $commentdocumentresult = $commentdocument->result_array();
            $revisionarr   = '';
            $revisionindex = 0;
            foreach ($commentdocumentresult as $dockey) {
                if(array_key_exists("DocumentInfo",$dockey))
                {
                    foreach ($dockey['DocumentInfo'] as $subdockey)
                    {
                        if(array_key_exists("RevisionNo",$subdockey) && $subdockey['RevisionNo'] == "1.2.0.5")
                        {
                            $revisionarr    = $subdockey;
                            $revisionindex  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                }
            }
            $subdocumentindex = "DocumentInfo.".$revisionindex.".Comments";
            $pushcomment = array($subdocumentindex => $newcomment);
            $wherecomment = array("DocumentName" => $documentname,"DocumentInfo.RevisionNo" => "1.2.0.5");
            $commentquery = $this->cimongo->where($wherecomment)->push($pushcomment)->update('DocComment');
            return $revisionindex;