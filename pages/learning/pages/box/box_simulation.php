
<?php require '../../includes/config.inc.php';?>
<head>
    <?php

        error_reporting(E_ALL);
        $_SESSION['debug'] = true;


        //define user access level

        $openaccess = 1;
        /* $requiredUserLevel = 5; */


         require BASE_URI . '/head.php';

        $general = new general;

        $navigator = new navigator;

        $formv1 = new formGenerator;

        require_once(BASE_URI . '/pages/learning/pages/box/classes/choices.class.php');
        $choices = new choices;

        require_once(BASE_URI . '/pages/learning/pages/box/classes/responses.class.php');
        $responses = new responses;

        require_once(BASE_URI . '/pages/learning/pages/box/classes/choices_command.class.php');
        $choices_command = new choices_command;

        require_once(BASE_URI . '/pages/learning/pages/box/classes/commands.class.php');
        $commands = new commands;

        require_once(BASE_URI . '/pages/learning/pages/box/classes/box_code.class.php');
        $box_code = new box_code;

      //custom path to classes
      //forward classes

    ?>

    <!--Page title-->
    <title>GIEQs Online Endoscopy Trainer - Scores - SMIC calculator</title>

    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/libs/animate.css/animate.min.css">


    <style>
       
        .gieqsGold {
            color: rgb(238, 194, 120);
        }
        .card-placeholder{
            width: 344px;
        }
        .form-control:disabled, .form-control[readonly] {
            opacity: 1.0;
            background-color: #f9eded4d;
        }
        .break {
            flex-basis: 100%;
            height: 0;
        }
        .flex-even {
             flex: 1;
        }
        .flex-nav {
             flex: 0 0 18%;
        }        
        .gieqsGoldBackground {
            background-color: rgb(238, 194, 120);
        }
        .tagButton {
            cursor: pointer;
        }    
      
        iframe {
            box-sizing: border-box;
            height: 25.25vw;
            left: 50%;
            min-height: 100%;
            min-width: 100%;
            transform: translate(-50%, -50%);
            position: absolute;
            top: 50%;
            width: 100.77777778vh;
        }
        .cursor-pointer {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .flex-even {
                flex-basis: 100%;
                }
        }

        @media (max-width: 768px) {
            .card-header {
                height:250px;
            }
            .card-placeholder{
                width: 204px;
            }
        }

        @media (min-width: 1200px) {
                #chapterSelectorDiv{           
                        top:-3vh;
                }
                #playerContainer{
                        margin-top:-20px;
                }
                #collapseExample {
                    position: absolute; 
                    max-width: 50vh; 
                    z-index: 25;
                }       

        }
    </style>
</head>

<body>
    <header class="header header-transparent" id="header-main">

        <!-- Topbar -->

        <?php require BASE_URI . '/pages/learning/includes/topbar.php';?>

        <!-- Main navbar -->

        <?php require BASE_URI . '/pages/learning/includes/nav.php';?>   

    </header>

    <?php
		if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
			$id = $_GET["id"];		
		} else {		
			$id = null;		
		}		    
           
        ?>
        
        <!-- load all video data -->

        <div id="id" style="display:none;"><?php if ($id){echo $id;}?></div>

        <!--- specifiy the tag Categories required for display  CHANGEME-->

        <?php
        $requiredTagCategories = ['66', '105'];
        ?>

        <div id="requiredTagCategories" style="display:none;"><?php echo json_encode($requiredTagCategories);?></div>       

            <!--CONSTRUCT TAG DISPLAY-->

            <!--GET TAG CATEGORY NAME 
            
            <?php

            //define the page for referral info

            //$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $url =  "{$_SERVER['REQUEST_URI']}";

            $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );

            ?>
            -->

        <div id="escaped_url" style="display:none;"><?php echo $escaped_url;?></div>

            <!--
                    
                TODO see other videos with similar tags, see videos with this tag, tag jump the video,
                list of chapters with associated tags [toggle view by category, chapter]
                
                -->


    <!-- Omnisearch -->
   
    <div class="main-content bg-gradient-dark">
        <!--Header CHANGEME-->

    <div class="d-flex align-items-end container">
        <p class="h1 mt-10">GIEQs Box Simulator</p>
    </div>
    <div class="d-flex align-items-end container">
        <p class="text-muted pl-4 mt-2"></p>
    </div>


        <!--Navigation-->

    <!-- <div id="navigationZone">
    <?php //require(BASE_URI . '/pages/learning/includes/navigation.php'); ?>
    </div> -->   
        <!--Video Display-->
    <div class="container mt-3">            
    <script>

        function round(value, precision) {
            var multiplier = Math.pow(10, precision || 0);
            return Math.round(value * multiplier) / multiplier;
        }

	function determineCOVERT (location, morphology, paris) {
			
			if ((location === null) || (morphology === null) || (paris ===null)){
		
				COVERT = '-';
				return COVERT;

			}else{
				
				
				var locationInt = +location;
				var morphologyInt = +morphology;
				var parisInt = +paris;
				
				
				if (isNaN(locationInt) || isNaN(morphologyInt) || isNaN(parisInt)){

				COVERT = '-';
				return COVERT;

				}else{
				
				
				var locationCategory;
				var morphologyCategory;
				var parisCategory;

				//need colon site
				//need morphology
				//need paris

				//convert to the required format

				//location proximal 9-13 others distal //category 1 distal 2 proximal

				
				if (locationInt < 9){
					locationCategory = 1;
				}else{
					locationCategory = 2;
				}
					
				if (morphologyInt == 1){
					
					morphologyCategory = 1; //granular
				}else if (morphologyInt == 2){
					
					morphologyCategory = 2; // non-granular
					
				}else if (morphologyInt > 2){  //can't calculate the score as serrated and mixed not supported
					
					COVERT = '-';
					return COVERT;
					
				}
					
					
				if (parisInt == 2){
					
					parisCategory = 1; // 0-IIa
					
				}else if (parisInt == 6){
					
					parisCategory = 2; // 0-IIa/Is
					
				}else if (parisInt == 1){
					
					parisCategory = 3; //0-Is
					
				}else{ // unsupported Paris class
					
					COVERT = '-';
					return COVERT;
				}	
			
			
				//now have categorical variables available only if they are correct type for this score	
					
				if (locationCategory == 2 && morphologyCategory == 1 && parisCategory == 1){
					
					COVERT = '0.7%';
				}else if (locationCategory == 1 && morphologyCategory == 1 && parisCategory == 1){
					
					COVERT = '1.2%';
				}else if (locationCategory == 2 && morphologyCategory == 1 && parisCategory == 2){
					
					COVERT = '4.2%';
				}else if (locationCategory == 1 && morphologyCategory == 1 && parisCategory == 2){
					
					COVERT = '10.1%';
				}else if (locationCategory == 2 && morphologyCategory == 1 && parisCategory == 3){
					
					COVERT = '2.3%';
				}else if (locationCategory == 1 && morphologyCategory == 1 && parisCategory == 3){
					
					COVERT = '5.7%';
				}else if (locationCategory == 2 && morphologyCategory == 2 && parisCategory == 1){
					
					COVERT = '3.8%';
				}else if (locationCategory == 1 && morphologyCategory == 2 && parisCategory == 1){
					
					COVERT = '6.4%';
				}else if (locationCategory == 2 && morphologyCategory == 2 && parisCategory == 2){
					
					COVERT = '12.7%';
				}else if (locationCategory == 1 && morphologyCategory == 2 && parisCategory == 2){
					
					COVERT = '15.9%';
				}else if (locationCategory == 2 && morphologyCategory == 2 && parisCategory == 3){
					
					COVERT = '12.3%';
				}else if (locationCategory == 1 && morphologyCategory == 2 && parisCategory == 3){
					
					COVERT = '21.4%';
				}				
					
				return COVERT;	
					
				}
			
			}
            
			//surely there should be a version involving size...            
		}

    //hie below if demarcated area = yes

    function noDemarcatedArea(){

        var labels = $('#size, #location, #morphology, #paris').parent().prev();
        var arrayToHide = $('#size, #location, #morphology, #paris').parent();

        $(labels).show();
        $(arrayToHide).show();
        $('#demarcation_imaging').val('Please select...');

        $('#demarcation_imaging').hide();
        $('#demarcation_imaging').parent().prev().hide();

    }

    function demarcatedArea(){

        var labels = $('#size, #location, #morphology, #paris').parent().prev();
        var arrayToHide = $('#size, #location, #morphology, #paris').parent();

        $(labels).hide();
        $(arrayToHide).hide();
        $('#demarcation_imaging').show();
        $('#demarcation_imaging').parent().prev().show();


        /* $('#size, #location, #morphology, #paris').parent().hide(); */

    }

	function determineSMIC (demarcation, size, location, morphology, paris, debug=true) {
			
			if ((demarcation == null)) {
				return 'Was there a demarcated area?';
            } else if ((demarcation == 1)) {
                return {
                "risk_text" : 'Very High Risk',
                "risk": 17.6,
                "odds": 16,
                }     
                
            } else if ((size == null) || (location == null) || (morphology == null) || (paris == null)) {
		
				return 'Missing Variables - please enter all 4 further characteristics';
			} else{
				
				//var demarcation = +demarcation;
				var sizeInt = +size;
				var locationInt = +location;
				var morphologyInt = +morphology;
				var parisInt = +paris;
				
				
				if (isNaN(sizeInt) || isNaN(locationInt) || isNaN(morphologyInt) || isNaN(parisInt)) {
					return 'Issue with variables supplied, please check they are numbers';
				} else {
				
					var SMICriskOR = 0;
					var SMICriskactual = 1.1;


					if (sizeInt == 2) {
						//>=30mm
						SMICriskOR = SMICriskOR + 1.12;

					} else if (sizeInt == 3) {
						//>=40mm
						SMICriskOR = SMICriskOR + 2*(1.12);

					} else if (sizeInt == 4) {
						//>=-50mm
						SMICriskOR = SMICriskOR + 3*(1.12);

					} else if (sizeInt == 5) {
						//>=60mm
						SMICriskOR = SMICriskOR + 4*(1.12);

					} else if (sizeInt == 6) {
						//>=70mm
						SMICriskOR = SMICriskOR + 5*(1.12);

					} else if (sizeInt == 7) {
						//>=80mm
						SMICriskOR = SMICriskOR + 6*(1.12);

					} else if (sizeInt == 8) {
						//>=90mm
						SMICriskOR = SMICriskOR + 7*(1.12);

					} else if (sizeInt == 9) {
						//>=100mm
						SMICriskOR = SMICriskOR + 8*(1.12);
					}
					
					if (locationInt == 1) {
						SMICriskOR = SMICriskOR + 1.91;
					}
					
					if (paris == 2) {
					    SMICriskOR = SMICriskOR + 2.73;

					} else if (paris == 3) {
					    SMICriskOR = SMICriskOR + 2.49;
					}

					if (morphology == 2) {
						SMICriskOR = SMICriskOR + 2.8;
					} else if (morphology == 3) {
						SMICriskOR = SMICriskOR + 0.72;
					}
						
					//round(SMICriskOR, 1);

					if (SMICriskOR == 0) {
						SMICriskOR = 1;
					}

					if (SMICriskOR == -0.28) {
						SMICriskOR = 0.72;
					}

					var SMICnumeric = SMICriskOR * SMICriskactual;

					SMICriskOR = round(SMICriskOR, 1);

					SMICnumeric = round(SMICnumeric, 1);

                    if (SMICnumeric < 10) {

                        var text = 'Low Risk';

                     }else if (SMICnumeric >= 10) {
                        var text = 'High Risk';
                    }

                    //return an object

                    return {
                        "risk_text" : text,
                        "risk": SMICnumeric,
                        "odds": SMICriskOR,
                    }

					//return  '<h3> ' + text + '</h3><h4>' + SMICnumeric + '% </h4> <br><br>(or ' + SMICriskOR + 'x the risk of a granular 0-IIa 20-29mm LSL in the colon proximal to the sigmoid without a demarcated area or depression, risk 1.1%)<br>';
					
				}
			
			}
			
			
		}

        function determineSMICnew (demarcation, size, location, morphology, paris, debug=true) {
			
			if ((demarcation == null)) {

				return 'Was there a demarcated area?';
            } else if ((demarcation == 1)) {
                return {

                "risk_text" : 'OVERT Risk',
                "risk": 22.1,
                "odds": 22.1,
                }               
             
                
            } else if ((size == null) || (location == null) || (morphology == null) || (paris == null)) {
		
				return 'Missing Variables - please enter all 4 further characteristics';
			} else {
				
				//var demarcation = +demarcation;
				var sizeInt = +size;
				var locationInt = +location;
				var morphologyInt = +morphology;
				var parisInt = +paris;
				
				
			if (isNaN(sizeInt) || isNaN(locationInt) || isNaN(morphologyInt) || isNaN(parisInt) ) {

                return 'Issue with variables supplied, please check they are numbers';

            } else {
                var SMICriskOR = -4.498799;
                var SMICriskactual = 1.1;

                /* if (kudovInt == 1){

                    SMICriskOR = SMICriskOR + 2.653242;

                }

                if (depressionInt == 1){

                    if (debug){

                        console.log(SMICriskOR);

                    }

                    SMICriskOR = SMICriskOR + 0.5877867;

                } */

                if (sizeInt == 2) {
                    //>=30mm
                    SMICriskOR = SMICriskOR + 0.1133287;

                } else if (sizeInt == 3) {
                    //>=40mm
                    SMICriskOR = SMICriskOR + 2*(0.1133287);

                } else if (sizeInt == 4) {
                    //>=-50mm
                    SMICriskOR = SMICriskOR + 3*(0.1133287);

                } else if (sizeInt == 5) {
                    //>=60mm
                    SMICriskOR = SMICriskOR + 4*(0.1133287);

                } else if (sizeInt == 6) {
                    //>=70mm
                    SMICriskOR = SMICriskOR + 5*(0.1133287);

                } else if (sizeInt == 7) {
                    //>=80mm
                    SMICriskOR = SMICriskOR + 6*(0.1133287);

                } else if (sizeInt == 8) {
                    //>=90mm
                    SMICriskOR = SMICriskOR + 7*(0.1133287);

                } else if (sizeInt == 9) {
                    //>=100mm
                    SMICriskOR = SMICriskOR + 8*(0.1133287);

                }

                if (locationInt == 1) {
                    SMICriskOR = SMICriskOR + 0.6471032;
                }



                if (paris == 2) {

                    SMICriskOR = SMICriskOR + 1.004302;

                } else if (paris == 3) {

                     SMICriskOR = SMICriskOR + 0.9122827;

                }

                if (morphology == 2){

                    SMICriskOR = SMICriskOR + 1.029619;

                    } else if (morphology == 3) {

                    SMICriskOR = SMICriskOR - 0.3285041;

                }
    
                //round(SMICriskOR, 1);

                /* if (SMICriskOR == 0){

                    SMICriskOR = 1;

                }

                if (SMICriskOR == -0.28){

                    SMICriskOR = 0.72;

                } */

                //SMICOR includes b0
                //formula to get cnacer is exp(x)/1+(exp(x))


                //return SMICriskOR + '%';


                SMIrisk = ((Math.exp(SMICriskOR))/(1+Math.exp(SMICriskOR)))*100;

                SMIrisk = round(SMIrisk, 1);


                //var SMICnumeric = SMICriskOR * SMICriskactual;

				/* 	SMICriskOR = round(SMICriskOR, 1);

					SMICnumeric = round(SMICnumeric, 1);
 */
                if (SMIrisk < 10) {
                    var text = 'Low Risk';

                } else if (SMIrisk >= 10) {
                    var text = 'High Risk';
                }

                    //return an object

                return {

                    "risk_text" : text,
                    "risk": SMIrisk,
                    "odds": SMIrisk,


                }

            /* var SMICnumeric = SMICriskOR * SMICriskactual;

            SMICriskOR = round(SMICriskOR, 1);

            SMICnumeric = round(SMICnumeric, 1);

            return SMICnumeric + '%  <br>(or ' + SMICriskOR + 'x the risk of a granular 0-IIa 20-29mm LSL in the colon proximal to the sigmoid without a demarcated area or depression, risk 1.1%)<br>';
            */

        }
			
			
		}

    }   

        
	
		$(document).ready(function() {

            demarcatedArea();

			$('.content').on('click', '#calculate', function(){

                    var demarcation = $('#demarcation').val();
                    var size = $('#size').val();
                    var location = $('#location').val();
                    var morphology = $('#morphology').val();
                    var paris = $('#paris').val();

                    var COVERT = determineSMICnew(demarcation, size, location, morphology, paris);

                if (typeof COVERT === 'object' && COVERT !== null){

                    $('#result').html('<h3 class="gieqsGold"> ' + COVERT.risk_text + '</h3>');
                    $('#result').append('<h4>' + COVERT.risk + '% </h4>');
                    $('#result').append('<p>The data was copied to your clipboard to paste back into the survey</p>');

                    $('#result').append('(or ' + COVERT.odds + 'x the risk of a granular 0-IIa 20-29mm LSL in the colon proximal to the sigmoid without a demarcated area or depression, risk 1.1%)<br>');
                    $('#result').addClass('gieqsGold');

                    generateScore();


                } else {

                    $('#result').html('<h3 class="gieqsGold"> ' + COVERT + '</h3>').addClass('gieqsGold');
                   

                }


                
                
                $('html, body').animate({
                    scrollTop: eval($('#result').offset().top - 200)
                }, 150);
			})

            $('.content').on('change', '.formInputs', function(){


                $('#result').html('');


            })

            $('.content').on('change', '#demarcation, #demarcation_imaging', function(){

                

                var demarcation = null;
                var demarcation_field = $('#demarcation').val();
                var true_demarcation = null;
                var showImagingWithoutDemarcation = false;


                if ($('#demarcation_imaging').val() == '1' || $('#demarcation_imaging').val() == '2'){

                    true_demarcation = false;

                }else if ($('#demarcation_imaging').val() == '3' || $('#demarcation_imaging').val() == '4'){

                    true_demarcation = true;

                }

                console.log('Demarcation field is ' + demarcation_field + ' true_demarcation = ' + true_demarcation);

                if (demarcation_field == 0){

                    demarcation = 0;

                }else if (demarcation_field == 1 && true_demarcation == false){

                    demarcation = 0;
                    showImagingWithoutDemarcation = true;

                }else if (demarcation_field == 1 && true_demarcation == true){

                    demarcation = 1;

                }else if (demarcation_field == 1 && true_demarcation == null){

                    demarcation = 1;
                
                }


                if (demarcation == 0){


                    noDemarcatedArea();

                    if (showImagingWithoutDemarcation == true){


                        $('#demarcation_imaging').show();
                         $('#demarcation_imaging').parent().prev().show();

                    }


                }else if (demarcation == 1){

                    demarcatedArea();

                    $('#demarcation_imaging').parent().show();           


                }

                })

		})
	
	</script>
</head>
<body>

	
	
    <div class='content'>

    <?php

    //$requiredValues = array("Location","Morphology","Paris");

    //$values = array();
    //$values = $lesion->GetValuesSpecific($requiredValues);

    //print_r($values);

    ?>

       
                <!-- <p><h3><b>Risk for Submucosal Invasion within a given LSL </h3>[algorithm ala Burgess 2018 Gastroenterology]</b></p>
        -->


        <!-- 
            
        
        Select 2 boxes

        $('#demarcation').select2()



        Add one based on the previous (code below)



        -->


        <?php

            $all_commands = $box_code->get_all_commands();
           // print_r($all_commands);

            $specific_command_interaction_and_position = $box_code->get_command_interaction_and_position(2);
        // print_r($specific_command_interaction_and_position);

            $responses_id = $box_code->get_next_response_given_interaction_id_and_order($specific_command_interaction_and_position['id'], $specific_command_interaction_and_position['order']);
            //print_r($responses_id);

            $first_level_commands = $box_code->get_first_level_commands();
            //print_r($first_level_commands);
        ?>
                
		<br>
		<div id='result' class='yellow'></div>
		<br>
		
        <div class="row mt-0">
            <h3>Command Response Tree</h3>
        </div>  
        <div class="row d-flex">
        <div class="col-md-6">
            <h3>hey GIEQs...</h3>
        </div>
        <div class="col-md-6">            
        </div>
        </div>
        <div class="row d-flex command-response-row" data-count="1">
            <div class="col-md-6">
                <label for="command_1" id="command_1label" title="" data-toggle="tooltip" data-placement="right" class="cursor-pointer" data-original-title="Click for an example">Command 1: &nbsp;&nbsp;</label>
                <div class="input-group mb-3">
                    <select name="command_1" id="command_1" class="commands formInputs form-control">
                    
                    <option hidden="" disabled="" selected="">please select</option>
                    
                    <?php
                    
                    foreach ($first_level_commands as $key => $value) {
                        echo "<option value='" . $value['id'] . "'>" . $value['text'] . "</option>";
                    }

                    ?>
                    
                    </select>
                    <br>
                </div>               
            </div>  
            <div class="col-md-5 d-flex align-items-center">
                <p class="responses" data-id=""></p>
            </div>

            <div class="col-md-1 d-flex align-items-center">

            <button class="input-group-btn cancel cancel-response-row text-dark ml-3" aria-hidden="true">×</button>

            <button class="input-group-btn edit edit-interaction-line-text text-dark ml-3" aria-hidden="true">Edit</button>
            <button class="input-group-btn add add-command-response-line text-dark ml-3" aria-hidden="true">Add</button>

            <button class="input-group-btn split split-interaction-here text-dark ml-3" aria-hidden="true">Split</button>
            <button class="input-group-btn action add-action text-dark ml-3" aria-hidden="true">Action</button>
            <button class="input-group-btn kpi add-kpi text-dark ml-3" aria-hidden="true">KPI</button>
            <button class="input-group-btn report add-report-link text-dark ml-3" aria-hidden="true">Report</button>
            <button class="input-group-btn education add-education-link text-dark ml-3" aria-hidden="true">Education</button>
            <button class="input-group-btn tag add-tag-link text-dark ml-3" aria-hidden="true">Tag</button>
            <button class="input-group-btn quality quality-link text-dark ml-3" aria-hidden="true">Quality</button>
            </div>
        </div>

        <div class="row mt-3">
            <h3>Background Variables</h3>
            <div class="d-flex background-variables"></div>
        </div>  

        <div class="row mt-3">
            <h3>Report</h3>
            <div class="flex-column report-lines"></div>
        </div>  

        <div class="row mt-3">
            <h3>Education Report</h3>
            <div class="flex-column education-report-lines"></div>

        </div>  


        <div class="row mt-3">
            <h3>KPIs </h3>
            <div class="flex-column kpis"></div>

        </div>  


        <div class="row mt-3">
            <h3>Actions</h3>
            <div class="flex-column actions"></div>

        </div>  

        <div class="row mt-3">
            <h3>Quality Report</h3>
            <div class="flex-column quality-report-lines"></div>

        </div>  

    </div>

            
    </div>



   
   
    

       
    </div>

    <div class="modal modal-new" id="modal_success" tabindex="-1" role="dialog" aria-labelledby="modal-new"
    aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="modal_title_6">More Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
                <div class="py-3 text-left">
                <h3 id="faculty-bio-name"></h3>
                  <p id="faculty-bio"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Close</button>

              

            </div>

            
        </div>
    </div>



    
    <!-- Modal -->
    

    <?php require BASE_URI . '/footer.php';?>

    <!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
    <!-- <script src="assets/js/purpose.core.js"></script> -->
    <!-- Page JS -->
     <!-- Google maps -->
    
    <!-- Purpose JS -->
    <script src=<?php echo BASE_URL . "/assets/js/purpose.js"?>></script>
    <!-- <script src=<?php echo BASE_URL . "/assets/js/generaljs.js"?>></script> -->
    <script>
    var videoPassed = $("#id").text();
                    </script>

    <script src=<?php echo BASE_URL . "/pages/learning/includes/social.js"?>></script>

    <script>
        
        //the number that are actually loaded
        
        var interaction_id = null;
        var branch_number = 1;
        var current_command = null;
        var current_response = null;
        var command_counter = 1;

        var edit_mode = false;

        //TODO

        //first box can only select from first level commands


        //define new interaction at this point

        //edit this line

        //add new reponse to interaction || add new response after this point

        //add action
        
        //add new KPI definition

        //add new report line

        //add new education report line

        //add new quality report line

        //add new tag link



        function addNewRow (position=false) {

            if (position) {


                position = parseInt(position);
                //TEMPORARILY SET THE COUNTER TO THE NEXT ROW

                var command_counter_save = command_counter;

                command_counter = position + 1;

            }


            var new_row = '<div class="row d-flex command-response-row" data-count="' + command_counter + '">';

            new_row += '<div class="col-md-6">';

            new_row += '<label for="command_' + command_counter + '" id="command_' + command_counter + 'label" title="" data-toggle="tooltip" data-placement="right" class="cursor-pointer" data-original-title="Click for an example">Command ' + command_counter + ': &nbsp;&nbsp;</label>';

            new_row += '<div class="input-group mb-3">';

            new_row += '<select name="command_' + command_counter + '" id="command_' + command_counter + '" class="commands formInputs form-control">';

            new_row += '<option hidden="" disabled="" selected="">please select</option>';

            new_row += '</select>';

            new_row += '<br>';

            new_row += '</div>';

            new_row += '</div>';


            new_row += '<div class="col-md-5 d-flex align-items-center">';

            new_row += '<p class="responses" data-id=""></p>';
        

            new_row += '</div>';

            new_row += '<div class="col-md-1 d-flex align-items-center">';

            new_row += '<button class="input-group-btn cancel cancel-response-row text-dark ml-3" aria-hidden="true">×</button>';

            new_row +=             '<button class="input-group-btn edit edit-interaction-line-text text-dark ml-3" aria-hidden="true">Edit</button>';

            new_row += '<button class="input-group-btn add add-command-response-line text-dark ml-3" aria-hidden="true">Add</button>';

            new_row += '<button class="input-group-btn split split-interaction-here text-dark ml-3" aria-hidden="true">Split</button>';

            new_row += '<button class="input-group-btn action add-action text-dark ml-3" aria-hidden="true">Action</button>';

            new_row += '<button class="input-group-btn kpi add-kpi text-dark ml-3" aria-hidden="true">KPI</button>';

            new_row += '<button class="input-group-btn report add-report-link text-dark ml-3" aria-hidden="true">Report</button>';

            new_row += '<button class="input-group-btn education add-education-link text-dark ml-3" aria-hidden="true">Education</button>';

            new_row += '<button class="input-group-btn tag add-tag-link text-dark ml-3" aria-hidden="true">Tag</button>';

            new_row += '            <button class="input-group-btn quality quality-link text-dark ml-3" aria-hidden="true">Quality</button>';


         

            new_row += '</div>';
        
            new_row += '</div>';

            if (position) {


                //TEMPORARILY SET THE COUNTER TO THE NEXT ROW


               

                command_counter = command_counter_save;

                //set all rows after to have the correct count

                //required changes .row attr data-count select name id label for id

                $('.command-response-row').each(function(){

                    if ($(this).attr('data-count') > (position)){

                        var count = $(this).attr('data-count');

                        count = parseInt(count);

                        $(this).attr('data-count', count + 1);

                        $(this).find('select').attr('name', 'command_' + (count + 1));

                        $(this).find('select').attr('id', 'command_' + (count + 1));

                        $(this).find('label').attr('for', 'command_' + (count + 1));

                        $(this).find('label').attr('id', 'command_' + (count + 1));

                        $(this).find('label').text('Command ' + (count + 1) + ': ');

                    }


                    

                })

                $('.command-response-row').eq(position-1).after(new_row);


            } else {

                $('.command-response-row').last().after(new_row);

            }

          



        }        

        //all subsequent boxes are from the same interaction until cancelled

        //make the box with the command and response uneditable until next branch removed

        //function to navigate the other way

        //function to make a new row with a new command dropdown based upon the interaction

        //so first interaction sets interaction id

        function resetRow (row_id) {

            $('#command_' + row_id).each(function(){
                
                //select the hidden row
               
                $(this).val('please select');
                
                //remove the response

                $(this).parent().parent().parent().find('.responses').text('');

                //$(this).attr('disabled', 'disabled');

            
            
         })


        }

        function makeBranchUneditable (row_id){

            //make the command uneditable

            //get the select box with the command id selected

            //find any option with attr('id') == command_id

            $('#command_' + row_id).each(function(){
                
               
                    $(this).attr('disabled', 'disabled');

                
                
             })

             $(this).parent().parent().parent().find('button').prop('disabled', true);
            
            //then make it uneditable

            //$('#my_select option:selected').attr('id');

        }

        function makeBranchEditable (row_id) {

            $('#command_' + row_id).each(function(){
                
               
                $(this).prop('disabled', false);

            
            
             })

          $(this).parent().parent().parent().find('button').prop('disabled', false);
       

        }

        function editRow(row_id){

            //switch the reponse for a text box containing the response


            $(document).find('.command-response-row').each(function(){

                if ($(this).attr('data-count') == row_id){

                    //get the current response text

                    //make the pen a tick

                    //perhaps hide instead of remove

                    var current_command = $(this).find('.commands').find(":selected").text();

                    if (current_command == 'please select'){

                        //end of a row

                        //create a new response above to edit

                        current_command = '';

                        $(document).find(".command-response-row[data-count='"+row_id+"']").find('.input-group').addClass('d-none').after('<textarea class="form-control" id="edit_command_' + current_command_id + '" name="edit_command_' + current_command_id + '" data-id="' + current_command_id + '">'+current_command+'</textarea>');


                    }

                    var current_command_id = $(this).find('.commands').find(":selected").val();

                    var fields = current_command.split('-');

                    current_command = fields[1];

                    current_command = current_command.trim();

                    $(this).find('.input-group').addClass('d-none').after('<textarea class="form-control" id="edit_command_' + current_command_id + '" name="edit_command_' + current_command_id + '" data-id="' + current_command_id + '">'+current_command+'</textarea>');


                    var current_response = $(this).find('.responses').text();

                    var current_response_id = $(this).find('.responses').attr('data-id');

                    $(this).find('.responses').parent().removeClass('align-items-center').addClass('align-items-end');

                    $(this).find('.responses').addClass('d-none').after('<textarea class="form-control" id="edit_response_' + current_response_id + '" name="edit_response_' + current_response_id + '" data-id="' + current_response_id + '">'+current_response+'</textarea>');

                }

            });




        }

        function saveInteraction(interaction_id, debug=false){

            //get an object of all the commands and responses

            //iterate through the rows

            var dataToSend = {

            interaction_id: interaction_id,

            commands: [],

            };

            var commands = [];

            var x = 0;

            $('.command-response-row').each(function(){

                $row_number = $(this).attr('data-count');

                //get command id

                $command_id = $(this).find('.commands').find(":selected").val();

                $response_id = $(this).find('.responses').attr('data-id');

                if (debug){

                    console.log('row number: ' + $row_number);

                }

                commands[x] = {

                    row_number: $row_number,

                    command_id: $command_id,

                    response_id: $response_id,

                };

                x++;

                
            });

            dataToSend.commands = commands;


            const jsonString = JSON.stringify(dataToSend);
            ////console.log(jsonString);
            //console.log(siteRoot + "/pages/learning/scripts/getNavv2.php");

            var request2 = $.ajax({
                async: false,

            beforeSend: function () {

            },
            url: siteRoot + "/pages/learning/pages/box/ajax/update_interaction.php",
            type: "POST",
            contentType: "application/json",
            data: jsonString,
            });



            request2.done(function (data) {

                console.log(data);

                response = JSON.parse(data);

            });

            request2.fail(function (jqXHR, textStatus, errorThrown) {

                console.error(
                    "The following error occurred: " +
                    textStatus, errorThrown
                );

            });

            return request2;
            

            





        }

        function writeEditedRow(row_id, debug=false){

            //get the text from the two textareas

            var command_text = $('#edit_command_' + row_id).val();

            var command_id = $('#edit_command_' + row_id).attr('data-id');

            var response_text = $('#edit_response_' + row_id).val();

            var response_id = $('#edit_response_' + row_id).attr('data-id');



            if (debug){

                console.log('command text: ' + command_text);

                console.log('response text: ' + response_text);

            }

            var dataToSend = {

            

            command_text: command_text,

            command_id: command_id,

            response_text: response_text,

            response_id: response_id,

            };

            //const jsonString2 = JSON.stringify(dataToSend);

            const jsonString = JSON.stringify(dataToSend);
            ////console.log(jsonString);
            //console.log(siteRoot + "/pages/learning/scripts/getNavv2.php");

            var request2 = $.ajax({
                async: false,

            beforeSend: function () {

            },
            url: siteRoot + "/pages/learning/pages/box/ajax/edit_response_interaction.php",
            type: "POST",
            contentType: "application/json",
            data: jsonString,
            });



            request2.done(function (data) {

                console.log(data);

                response = JSON.parse(data);

                if (response.commands_update == 1 || response.responses_update == 1){

                    //show updated select boxes
                    //getResponse(command_id);

                    //hide the edit boxes

                    $('#edit_command_' + row_id).remove();

                    $('#edit_response_' + row_id).remove();

                     //modify them based on the entered data here

                     //if command was changed, change the text in the select box

                     if (response.commands_update == 1){

                        //change the text in the select box

                        $(document).find(".command-response-row[data-count='"+row_id+"']").find("option[value='"+command_id+"']").text(command_id + ' - ' + command_text);

                     }

                     //if response was changed

                     if (response.responses_update == 1){

                        //change the text in the select box

                        $(document).find(".responses[data-id='"+response_id+"']").text(response_text);

                     }



                    //reshow the dropdowns and responses

                    $(document).find(".responses[data-id='"+response_id+"']").removeClass('d-none');

                    $(document).find(".command-response-row[data-count='"+row_id+"']").find('.input-group').removeClass('d-none');

                    //update the button text to edit






                    //actually needs to edit command or response depending on which is changed


                    //$(document).find(".responses[data-id='"+response_id+"']").removeClass('d-none');

                    
                    

                   




                }else{

                    //modification not required
                    $('#edit_command_' + row_id).remove();

                    $('#edit_response_' + row_id).remove();

                    $(document).find(".responses[data-id='"+response_id+"']").removeClass('d-none');

                    $(document).find(".command-response-row[data-count='"+row_id+"']").find('.input-group').removeClass('d-none');

                }

                $(document).find(".command-response-row[data-count='"+row_id+"']").find('.save-interaction-line-text').addClass('edit-interaction-line-text').removeClass('save-interaction-line-text').text('Edit');





            })

            return request2;

            }


        function removeBranch (row_id) {

            //check its the current branch

            if (row_id == (command_counter) && row_id > 1){

                //remove most recent branch

                $(document).find('.command-response-row').each(function(){

                if ($(this).attr('data-count') == row_id){

                    $(this).remove();

                }

                });

                //make the previous row editable


            }else if (row_id == 1) {

                alert('You cannot remove the first branch');


            }else{

                alert('You can only remove the last branch');

            }

            command_counter--;


           


        }

        function getResponse (command_id){

            //alert(command_id);
            var response = null;

            var dataToSend = {

            command_id: command_id,

            }

            //const jsonString2 = JSON.stringify(dataToSend);

            const jsonString = JSON.stringify(dataToSend);
            ////console.log(jsonString);
            //console.log(siteRoot + "/pages/learning/scripts/getNavv2.php");

            var request2 = $.ajax({
                async: false,

            beforeSend: function () {

            },
            url: siteRoot + "/pages/learning/pages/box/ajax/get_response.php",
            type: "POST",
            contentType: "application/json",
            data: jsonString,
            });



            request2.done(function (data) {
            
                console.log(data);
                //alert(data);
            
                response = JSON.parse(data);

            
            
            
            })

            return request2;

            
                            /* alterrnate code
                            
                            var return_first;
                function callback(response) {
                return_first = response;
                //use return_first variable here
                }

                $.ajax({
                'type': "POST",
                'global': false,
                'dataType': 'html',
                'url': "ajax.php?first",
                'data': { 'request': "", 'target': arrange_url, 'method': method_target },
                'success': function(data){
                    callback(data);
                },
                });
                            
                            */


        }


        $(document).ready(function () {

            $(document).on('click', '.add-command-response-line', function(){


                var row_id = $(this).parent().parent().attr('data-count');


               // addNewRow(row_id);
               if ($(".save-interaction-line-text")[0]){
                    // Do something if class exists
                    alert('Please save the previous element.');
                } else {
                    // Do something if class does not exist
                    addNewRow1(row_id);
                    
                    //edit button reads save

                    $(this).removeClass('add-command-response-line').addClass('save-interaction-line-text').text('Save');
                }
               

                editRow(row_id + 1);

                command_counter++;



            });

            $(document).on('click', '.save-interaction-line-text', function(){


                var row_id = $(this).parent().parent().attr('data-count');


                console.log(row_id);

                if ($("#edit_command_" + row_id)[0]){
                    writeEditedRow(row_id);
                } else {
                    writeNewRow(row_id);
                }

                //edit button reads save


            });
            
            $(document).on('click', '.edit-interaction-line-text', function(){


                var row_id = $(this).parent().parent().attr('data-count');



                if (row_id == command_counter){

                    alert('You cannot edit the current branch');

                    return;

                }


                console.log(row_id);

                editRow(row_id);

                //edit button reads save

                $(this).removeClass('edit-interaction-line-text').addClass('save-interaction-line-text').text('Save');

            });


            $(document).on('click', '.cancel-response-row', function(){

                var row_id = $(this).parent().parent().attr('data-count');

                console.log(row_id);

                removeBranch(row_id);

                makeBranchEditable(row_id - 1);

                resetRow(row_id - 1);

            });


            $(document).on('change', '.commands', function(){

                var command_id = $(this).val();
                
                //get the current row id

                var row_id = $(this).parent().parent().parent().attr('data-count');

                //stop editing for that row

                makeBranchUneditable(row_id);


                var responsetext = getResponse(command_id);

                console.dir(responsetext.responseText);

                //return;
                
                var response = JSON.parse(responsetext.responseText);

                if (response.command_position == 1){

                    interaction_id = response.interaction_id;

                }

                if (response['responses_id'] == 'no response'){

                    $(this).parent().parent().parent().find('.responses').attr('data-id', '');

                    $(this).parent().parent().parent().find('.responses').text('End of Interaction');

                    return;

                }else if (response['responses_id'] == 'command does not exist within a known interaction') {

                    $(this).parent().parent().parent().find('.responses').attr('data-id', '');

                    $(this).parent().parent().parent().find('.responses').text('command does not exist within a known interaction');

                    return;

                }else{

                $(this).parent().parent().parent().find('.responses').attr('data-id', response.responses_id);

                $(this).parent().parent().parent().find('.responses').text(response.responses_text);


                //set the row number

                command_counter++;

                addNewRow();

                //add the options to the select box

                    console.dir(response.next_level_commands);
            
                $.each(response.next_level_commands, function (i, item) {

                    
                    console.log(item.id);

                    $('#command_' + command_counter).append($('<option>', { 
                        value: item.id,
                        text : item.text 
                    }));
                });

                


                //get the next commands

                //should be in the response
                
                }

            });

            $(document).on('click', '.split-interaction-here', function(){

                    var row_id = $(this).parent().parent().attr('data-count');                    

                    console.log(row_id);

                    var commadId = [];
                    var rsponseId = [];
                    var rowCounter = 1;

                    $('.command-response-row').each(function() {

                        var count = $(this).attr('data-count'); 
                       
                        if (rowCounter <= row_id) {

                            count = parseInt(count);
                            commadId.push($('#command_' + rowCounter).val());
                            rsponseId.push( $(document).find(".command-response-row[data-count='"+rowCounter+"']").find('p').attr('data-id'));                           
                            rowCounter++;
                        }

                    });

                    var dataToSend = {           

                        command_ids: commadId,
                        response_ids: rsponseId,                      

                    };

                        const jsonString = JSON.stringify(dataToSend);
                        console.log(jsonString);

                        var request2 = $.ajax({
                        async: false,

                        beforeSend: function () {

                        },
                        url: siteRoot + "/pages/learning/pages/box/ajax/split_response_interaction.php",
                        type: "POST",
                        contentType: "application/json",
                        data: jsonString,
                        });

                    

            })

        })


        var loaded = 1;

        //the number the user wants
        var loadedRequired = 1;

        var firstTime = 1; var activeStatus = 1;

        var requiredTagCategoriesText = $("#requiredTagCategories").text();

        var requiredTagCategories = JSON.parse(requiredTagCategoriesText);

        function copyToClipboard(text) {
    if (window.clipboardData && window.clipboardData.setData) {
        // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
        return window.clipboardData.setData("Text", text);

    }
    else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
        }
        catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return false;
        }
        finally {
            document.body.removeChild(textarea);
        }
    }
}

        function generateScore(){

                var demarcation = $('#demarcation').val();
				var size = $('#size').val();
				var location = $('#location').val();
				var morphology = $('#morphology').val();
				var paris = $('#paris').val();
                var demarcation_imaging = $('#demarcation_imaging').val();

                var COVERT = determineSMIC(demarcation, size, location, morphology, paris);




                            var score =  {
                    "demarcation": demarcation,
                    "demarcation_imaging": demarcation_imaging,
                    "size": size,
                    "location": location,
                    "morphology": morphology,
                    "paris": paris,
                    "risk": COVERT.risk,
                    "odds": COVERT.odds,
                    "text": COVERT.risk_text,
                    };

                    console.log(score);
                    console.log(JSON.stringify(score));

                    //copy to  clipboard

                    copyToClipboard(JSON.stringify(score));
            
        }
        

        function refreshNavAndTags(){

            var screenTop = $(document).scrollTop();

            //console.log(top);

            var tags = [];

                $('.tag').each(function(){

                    if ($(this).is(":checked")){
                        tags.push($(this).attr('data'));
                    }


                })

                

                //push how many loaded, use loaded variable

                console.dir(tags);

                /*var key = $(this).attr('data');

				const dataToSend = {

					key: key,

				}*/var dataToSend = {

                    tags: tags,
                    requiredTagCategories: requiredTagCategories,
                    active: activeStatus,

                    }

                    //const jsonString2 = JSON.stringify(dataToSend);

				const jsonString = JSON.stringify(dataToSend);
				////console.log(jsonString);
				//console.log(siteRoot + "/pages/learning/scripts/getNavv2.php");

				var request2 = $.ajax({
					beforeSend: function () {

                        $('#videoCards').html("<div class=\"d-flex align-items-center\"><strong>Loading...</strong><div class=\"spinner-border ml-auto\" role=\"status\" aria-hidden=\"true\"></div></div>");
                        //for each tags array push the badges to the tags shown area
                        var html = '';
                        $.each(tags, function(k,v){

                            //HERE WE HAVE THE TAGID
                            
                            var tagid = v;

                            //get the name and category

                            var tagName = $('body').find('#navigationZone').find('#tag'+v).siblings().text();

                            var tagCategory = $('body').find('#navigationZone').find('#tag'+v).parent().parent().parent().parent().find('span').text();

                            html += '<span class="badge bg-gieqsGold text-dark mx-2 my-2 tagButton" data="'+v+'">'+tagCategory+ ' / ' +tagName+' <i style="float:right;" class="fas fa-times removeTag cursor-pointer ml-1" data="'+v+'"></i></span>';

                        });
                        $('body').find('#navigationZone').find('#shown-tags').html(html);

					},
					url: siteRoot + "/pages/learning/scripts/getNavv2.php",
					type: "POST",
					contentType: "application/json",
					data: jsonString,
				});



				request2.done(function (data) {
                    // alert( "success" );
                    if (data != '[]'){
                        var toKeep = $.parseJSON(data.trim());
                        //alert(data.trim());
                        console.dir(toKeep);
                        
                             
                            $('.tag').each(function(){

                                var tagid = $(this).attr('data');

                                if (toKeep.indexOf(tagid) > -1){

                                    $(this).attr('disabled', false);

                                }else{

                                    $(this).attr('disabled', true);
                                }

                            })    

                      
                    }
					//$(document).find('.Thursday').hide();
                })
                
                request2.then(function (data) {
                    var tags = [];

                    $('.tag').each(function(){

                        if ($(this).is(":checked")){
                            tags.push($(this).attr('data'));
                        }


                    })

                    //TODO ADD ABILITY TO PASS A PARAMETER HERE INDICATING NUMBER LOADED
                    //THEN MODIFY LAYOUT AND NUMBER LOADED

                    console.dir(tags);

                    var dataToSend = {

                        tags: tags,
                        loaded: loaded,
                        loadedRequired: loadedRequired,
                        requiredTagCategories: requiredTagCategories,
                        referringUrl: $('#escaped_url').text(), active: activeStatus,


                    }

                    const jsonString2 = JSON.stringify(dataToSend); 
                    const jsonString = JSON.stringify(tags);
                    console.dir(jsonString2);


                    var request3 = $.ajax({
					beforeSend: function () {


					},
					url: siteRoot + "/pages/learning/scripts/getVideos.php",
					type: "POST",
					contentType: "application/json",
					data: jsonString2,
                    });
                    request3.done(function (data) {
                    // alert( "success" );
                    if (data){
                        //var toKeep = $.parseJSON(data.trim());
                        //alert(data.trim());
                        //console.dir(toKeep);

                        $('#videoCards').html(data);
                        $('body').find('#itemCount').each(function(){

                            var count = $('body').find('.individualVideo').length;
                            $(this).text(count);


                        })


                        if (firstTime == 1){
                        $('body').on('click', '#loadMore', function () {

                        loadedRequired = loadedRequired + 1;
                        refreshNavAndTags();

                        })
                        }                        

                        if (firstTime > 1 && loadedRequired > 1){

                                var loadedRequiredMultiple = ((loadedRequired-1) * 10)-3;

                                //console.log(loadedRequiredMultiple);

                                //scroll to current level

                            
                                $("body,html").animate(
                                {
                                    scrollTop: $('body').find('.individualVideo:eq('+loadedRequiredMultiple +')').offset().top
                                },
                                2 //speed
                                );
                        }
                       
                        
                        firstTime = firstTime + 1;
                        //$('body').find('.individualVideo:eq('+loadedRequiredMultiple +')').scrollTop(300);
                       
                    }
					//$(document).find('.Thursday').hide();
                })
				})
        }

        $(document).ready(function () {

            //refreshNavAndTags();

            $('#refreshNavigation').click(function(){


                firstTime = 1;
                 //the number that are actually loaded
                loaded = 1;

                //the number the user wants
                loadedRequired = 1;
                
                $('.tag').each(function(){

                    if ($(this).is(":checked")){
                        
                        $(this).prop('checked', false);
                    }


                })

                refreshNavAndTags();

            })

            //on load check if any are checked, if so load the videos

            //if none are checked load 10 most recent videos for these categories

            $('.tag').click(function(){

                refreshNavAndTags();

            })

            $('body').on('click', '.removeTag', function(){

                var tagToRemove = $(this).attr('data');
                //remove the check from the tag removed

                $('.tag').each(function(){

                if ($(this).attr("data") == tagToRemove){
                    
                    $(this).prop('checked', false);

                }


                })


                refreshNavAndTags();

            })
            //active behaviour

            $('body').on('change', '#active', function(){

                var active = $(this).children("option:selected").val();
                //remove the check from the tag removed

                activeStatus = active;

                refreshNavAndTags();

            })

            $('#demarcationlabel').click(function(){

            var name = $(this).attr('data-name');
            var bio = $(this).attr('data-bio');

            $('#faculty-bio-name').text(name);

            if (bio == ''){

                $('#faculty-bio').html('No bio yet');

            }else{
                $('#faculty-bio').html(bio);
            }

            $('.modal-new').modal('show');

            })


        })



        function addNewRow1 (position=false) {  
            

            if (position) {
                position = parseInt(position);
                //TEMPORARILY SET THE COUNTER TO THE NEXT ROW

                var command_counter_save = command_counter;

                command_counter = position + 1;

            }

            var endInteraction = 0;
            
            if ($('.command-response-row').length == position) { 

                $('.command-response-row').each(function() {

                if ($(this).attr('data-count') == position) {

                    var count = $(this).attr('data-count');                       

                    count = parseInt(count);                  
                    if ($(this).find('p').text()) {
                        $(this).find('.responses').remove('p');
                        $(this).find('.align-items-center:first').addClass('align-items-end');
                        $(this).find('.align-items-center:first').html('<textarea class="form-control" id="response_' + count + '" name="response_' + count + '" data-id="' + count + '"></textarea>');
                        $(this).find('.align-items-center:first').removeClass('align-items-center');
                        endInteraction = 1;
                    }                  

                }                   

                }) 
            }

            var new_row = '<div class="row d-flex command-response-row" data-count="' + command_counter + '">';

            new_row += '<div class="col-md-6">';

            new_row += '<label for="command_' + command_counter + '" id="command_' + command_counter + 'label" title="" data-toggle="tooltip" data-placement="right" class="cursor-pointer" data-original-title="Click for an example">Command ' + command_counter + ': &nbsp;&nbsp;</label>';

            new_row += '<div class="input-group mb-3 new_command">';


            new_row += '<textarea class="form-control" id="command_' + command_counter + '" name="command_' + command_counter + '" data-id="' + command_counter + '"></textarea>';

            new_row += '<br>';

            new_row += '</div>';

            new_row += '</div>';

            new_row += '<div class="col-md-5 d-flex align-items-end">';
            new_row += '<div class="input-group mb-3 new_response">';
            new_row += '<textarea class="form-control" id="response_' + command_counter + '" name="response_' + command_counter + '" data-id="' + command_counter + '"></textarea>';
            if (endInteraction == 1) {
                new_row += '<span style="margin:10px;"><label for="Interaction" class="cursor-pointer">Last Interaction</label><input type="checkbox" name="endInteraction" id="endInteraction_'+ command_counter +'" onclick="removeRespnsebox(this.id)"></span>';
            }
            new_row += '</div>';

            new_row += '</div>';  

            if (position) {

                //TEMPORARILY SET THE COUNTER TO THE NEXT ROW  

                command_counter = command_counter_save;

                //set all rows after to have the correct count

                //required changes .row attr data-count select name id label for id

                $('.command-response-row').each(function() {

                    if ($(this).attr('data-count') > (position)) {

                        var count = $(this).attr('data-count');                       

                        count = parseInt(count);

                        $(this).attr('data-count', count + 1);

                        $(this).find('select').attr('name', 'command_' + (count + 1));

                        $(this).find('select').attr('id', 'command_' + (count + 1));

                        $(this).find('label').attr('for', 'command_' + (count + 1));

                        $(this).find('label').attr('id', 'command_' + (count + 1));

                        $(this).find('label').text('Command ' + (count + 1) + ': ');

                    }                   

                    })                  

                     $('.command-response-row').eq(position-1).after(new_row);


            } else {                
                $('.command-response-row').last().after(new_row);
            }

        }   
        
        function removeRespnsebox(checkboxid) 
        {                       
            var respons_id = checkboxid.split('_')
            $("#response_" + respons_id[1]).toggle();
           
        }


        function writeNewRow(row_id, debug=true) {           

            //get the text from the two textareas
            var new_row = parseInt(row_id) + 1;
           // alert(new_row);
            var command_text = $('#command_' + new_row).val();

            var command_id = $('#command_' + new_row).attr('data-id');

            var response_text = $('#response_' + new_row).val();

            var response_id = $('#response_' + new_row).attr('data-id');

            var pre_command_id = $('#command_' + row_id).val();
            var pre_response_id = $(document).find(".command-response-row[data-count='"+row_id+"']").find('p').attr('data-id');

            if (debug) {

                console.log('command text: ' + command_text);

                console.log('response text: ' + response_text);

            }

            var dataToSend = {           

                command_text: command_text,
                command_id: command_id,
                response_text: response_text,
                response_id: response_id,
                pre_command_id: pre_command_id,
                pre_response_id:pre_response_id, 


            };

            const jsonString = JSON.stringify(dataToSend);
            console.log(jsonString);

            var request2 = $.ajax({
                async: false,

                beforeSend: function () {

                },
                url: siteRoot + "/pages/learning/pages/box/ajax/add_response_interaction.php",
                type: "POST",
                contentType: "application/json",
                data: jsonString,
            });

            request2.done(function (data) {

                console.log(data);

                response = JSON.parse(data);

                //alert(response);

                if (response.commands_add == 1 || response.response_add == 1) {

                    $('#command_' + new_row).remove();

                    $('#response_' + new_row).remove();

                    if (response.commands_add == 1) {
                        $(document).find(".command-response-row[data-count='"+new_row+"']").find('.new_command').append('<select name="command_' + new_row + '" id="command_' + new_row + '" class="commands formInputs form-control"><option hidden="" disabled="" >please select</option><option hidden="" disabled=""  selected="">'+ command_text +'</option></select>');
                    }
                    if (response.response_add == 1) {
                        $(document).find(".new_response").append('<p class="responses" data-id="' + new_row +'">' + response_text +'</p>');
                    }

                    $(document).find(".responses[data-id='"+response_id+"']").removeClass('d-none');

                    $(document).find(".command-response-row[data-count='"+new_row+"']").find('.input-group').removeClass('d-none');

                } else {
                   
                    $('#command_' + new_row).remove();

                    $('#response_' + new_row).remove();

                    $(document).find(".responses[data-id='"+response_id+"']").removeClass('d-none');

                    $(document).find(".command-response-row[data-count='"+new_row+"']").find('.input-group').removeClass('d-none');
                   
                }

                $(document).find(".command-response-row[data-count='"+row_id+"']").find('.save-interaction-line-text').addClass('add-command-response-line').removeClass('save-interaction-line-text').text('Add');

                })

                return request2;


        }
    </script>
</body>
</html>