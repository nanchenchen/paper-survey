<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="questionnaire"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" ng-app="questionnaire"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" ng-app="questionnaire"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-app="questionnaire" > <!--<![endif]-->
<head>
    

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.css">
<link rel=stylesheet type="text/css" media=all href=style.css />
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/angular.js"></script>
<script src="js/app.js"></script>

<script type='text/javascript'>


</script>
</head>
<body>
<div ng-controller="FormController as formCtrl">

<div id=pdf>
<a class="btn btn-default" id=open_pdf target="_blank">Open in a new window</a> <br />
<object id=pdf_file width=650 height=95% type='application/pdf'></object>
</div>

<div id=controlPanel>
<a class="btn btn-default" href=view_list.php>←Back to list</a>
<div id=save>
<span id=last_time><small ng-show="formCtrl.last_user">Last modified by {{ formCtrl.last_user }} at {{ formCtrl.last_time }}</small></span>
<a ng-click="formCtrl.submit()" id="saveBtn" class="btn btn-primary">Save</a>
</div>
<hr />
</div>
<div id=form>
<form novalidate>
    <ol class="questionnaire">
        <li class="item form-group">
            <div class=question>Who are you?</div>
            <span class="option" ng-repeat="user in formCtrl.users">
                <input ng-model="formCtrl.analysis.user" type=radio id=data_user value="{{user}}" required />{{user}}
            </span>
        </li>
        <li class="item form-group">
            <div class=question>Does the paper use data to study Posts / Messages / Content?</div>
            <input ng-model="formCtrl.analysis.is_target" type=radio id=for_content value=1 required />Yes 
            <input ng-model="formCtrl.analysis.is_target" type=radio id=for_content value=0 required />No
        </li>
        <div ng-show="formCtrl.isTarget()">

        <li class="item form-group">
            <div class=question>What major sources of data does the paper use? (check all applied)</div>
            <span class="option" ng-repeat="source in formCtrl.data_sources">
                <input ng-model="formCtrl.analysis.data_sources[source]" type=checkbox id=data_source value="{{source}}" />{{source}}
            </span> <br />
            Others (split by ,): <input ng-model="formCtrl.analysis.data_source_others" class="form-control" type=text id=data_source_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            For the online communication data, roughly what amount of data is used?<br />
            (e.g. 100 users, 1000 tweets)</div>
            <input ng-model="formCtrl.analysis.data_amount" class="form-control" type=text id=data_amount width=100/>
        </li>
        <li class="item form-group">
            <div class=question>What other aspects of online communication data are studied?
</div>
            <span class="option" ng-repeat="aspect in formCtrl.other_aspects">
            <input ng-model="formCtrl.analysis.other_aspects[aspect]" type=checkbox id=other_aspects value="{{aspect}}" />{{aspect}}
            </span> <br />
            Others (split by ,): <input ng-model="formCtrl.analysis.other_aspects_others" class="form-control" type=text id=other_aspects_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            What are the main research questions posed/investigated/explored by the paper? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="formCtrl.analysis.research_questions"  class="form-control" class="form-control" id=research_questions rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>
            Is the paper *primarily* concerned with: <br />
            (social phenomena includes individual, group, interactional, or otherwise human-related phenomena)
            </div>
            <span class="option" ng-repeat="primary_concern in formCtrl.primary_concerns">
                <input ng-model="formCtrl.analysis.primary_concerns[primary_concern]" type=checkbox id=primary_concern value="{{primary_concern}}" />{{primary_concern}} <br />
            </span> <br />
            Others (split by ,): <input ng-model="formCtrl.analysis.primary_concern_others" class="form-control" type=text id=primary_concern_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            In the authors' own words, what methods of analysis are applied to the online communication data? <br />
            (e.g. manual/auto content analysis, machine learning, some type of modeling, close reading, qualitative analysis, etc.)
            </div>
            <textarea ng-model="formCtrl.analysis.methods_authors" class="form-control" id=methods_authors rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>
            In your words, what methods of analysis are used?
            </div>
            <span class="option" ng-repeat="method in formCtrl.methods_us">
                <input ng-model="formCtrl.analysis.methods_us[method.name]" type=checkbox id=methods_us value="{{method.name}}" />{{method.desc}} <br />
            </span> <br />
            Others (split by ,): <input ng-model="formCtrl.analysis.methods_us_others" class="form-control" type=text id=methods_us_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            How are the results presented?
            </div>
            <span class="option" ng-repeat="result_presentation in formCtrl.result_presentations">
                <input ng-model="formCtrl.analysis.result_presentations[result_presentation]" type=checkbox id=result_presentation value="{{result_presentation}}" />{{result_presentation}}  <br />
            </span> <br />
            Others (split by ,): <input ng-model="formCtrl.analysis.result_presentation_others" class="form-control" type=text id=result_presentation_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            What variables do they look at for answering their research questions? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="formCtrl.analysis.variables" class="form-control" id=vis_purpose rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>Should we look at the visualizations? </div>
            <input ng-model="formCtrl.analysis.contains_vis" type=radio id=contains_vis value=1 />Yes 
            <input ng-model="formCtrl.analysis.contains_vis" type=radio id=contains_vis value=0 />No
        </li>
        <li class="item form-group">
            <div class=question>
            For each visualizations in the paper, what is the primary question they answer? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="formCtrl.analysis.vis_purpose"  class="form-control" id=vis_purpose rows=10 cols=100></textarea>
        </li>
        </div>
    </ol>
    
</form>

</div>
</div>
</body>
</html>