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
$(function(){
    sort = getUrlVars()["sort"];
    order = getUrlVars()["order"];
    $("#back_list").prop("href", "view_list.php?sort=" + sort + "&order=" + order);
});
</script>
</head>
<body>
<div ng-controller="FormController">

<div id=pdf>
<a class="btn btn-default" id=open_pdf target="_blank">Open in a new window</a> <br />
<object id=pdf_file width=38% height=95% type='application/pdf'></object>
</div>

<div id=controlPanel>
<a id=back_list class="btn btn-default" >←Back to list</a>
<div id=save>

<span id=last_time><small ng-show="last_user">Last modified by {{ last_user }} at {{ last_time }}</small></span>
<a ng-hide="isFinished()" ng-click="done(1)" id="saveBtn" class="btn btn-primary">Finished</a>
<a ng-show="isFinished()" ng-click="done(0)" id="saveBtn" class="btn btn-primary">Unfinished</a>
</div>
<hr />
</div>
<div id=form>
<form name=form novalidate>
    <ol class="questionnaire">
        <li class="item form-group">
            <div class=question>Who are you?</div>
            <label class="option" ng-repeat="user in users">
                <input ng-model="analysis.user" type=radio id=data_user value="{{user}}" required />{{user}}
            </label>
        </li>
        <li class="item form-group">
            <div class=question>Does the paper use data to study Posts / Messages / Content?</div>
            <input ng-model="analysis.is_target" type=radio id=for_content value=1 required />Yes 
            <input ng-model="analysis.is_target" type=radio id=for_content value=0 required />No
        </li>
        <div ng-show="isTarget()">

        <li class="item form-group">
            <div class=question>What major sources of data does the paper use? (check all applied)</div>
            <label class="option" ng-repeat="source in data_sources">
                <input ng-model="analysis.data_sources[source]" type=checkbox id=data_source value="{{source}}" />{{source}}
            </label> <br />
            Others (split by ,): <input ng-model="analysis.data_source_others" class="form-control" type=text id=data_source_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            For the online communication data, roughly what amount of data is used?<br />
            (e.g. 100 users, 1000 tweets)</div>
            <input ng-model="analysis.data_amount" class="form-control" type=text id=data_amount width=100/>
        </li>
        <li class="item form-group">
            <div class=question>What other aspects of online communication data are studied?
</div>
            <label class="option" ng-repeat="aspect in other_aspects">
            <input ng-model="analysis.other_aspects[aspect]" type=checkbox id=other_aspects value="{{aspect}}" />{{aspect}}
            </label> <br />
            Others (split by ,): <input ng-model="analysis.other_aspects_others" class="form-control" type=text id=other_aspects_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            What are the main research questions posed/investigated/explored by the paper? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="analysis.research_questions"  class="form-control" class="form-control" id=research_questions rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>
            What variables do they look at for answering their research questions? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="analysis.variables" class="form-control" id=vis_purpose rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>
            Is the paper *primarily* concerned with: <br />
            (social phenomena includes individual, group, interactional, or otherwise human-related phenomena)
            </div>
            <label class="option" ng-repeat="primary_concern in primary_concerns">
                <input ng-model="analysis.primary_concerns[primary_concern]" type=checkbox id=primary_concern value="{{primary_concern}}" />{{primary_concern}} <br />
            </label> <br />
            Others (split by ,): <input ng-model="analysis.primary_concern_others" class="form-control" type=text id=primary_concern_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            In the authors' own words, what methods of analysis are applied to the online communication data? <br />
            (e.g. manual/auto content analysis, machine learning, some type of modeling, close reading, qualitative analysis, etc.)
            </div>
            <textarea ng-model="analysis.methods_authors" class="form-control" id=methods_authors rows=10 cols=100></textarea>
        </li>
        <li class="item form-group">
            <div class=question>
            In your words, what methods of analysis are used?
            </div>
            <label class="option" ng-repeat="method in methods_us">
                <input ng-model="analysis.methods_us[method.name]" type=checkbox id=methods_us value="{{method.name}}" />{{method.desc}} <br />
            </label> <br />
            Others (split by ,): <input ng-model="analysis.methods_us_others" class="form-control" type=text id=methods_us_others size=10 />
        </li>
        <li class="item form-group">
            <div class=question>
            How are the results presented?
            </div>
            <label class="option" ng-repeat="result_presentation in result_presentations">
                <input ng-model="analysis.result_presentations[result_presentation]" type=checkbox id=result_presentation value="{{result_presentation}}" />{{result_presentation}}  <br />
            </label> <br />
            Others (split by ,): <input ng-model="analysis.result_presentation_others" class="form-control" type=text id=result_presentation_others size=10 />
        </li>
        
        <li class="item form-group">
            <div class=question>Should we look at the visualizations? </div>
            <input ng-model="analysis.contains_vis" type=radio id=contains_vis value=1 />Yes 
            <input ng-model="analysis.contains_vis" type=radio id=contains_vis value=0 />No
        </li>
        <li class="item form-group">
            <div class=question>
            For each visualizations in the paper, what is the primary question they answer? <br />
            (one per line, in the authors words as much as possible)
            </div>
            <textarea ng-model="analysis.vis_purpose"  class="form-control" id=vis_purpose rows=10 cols=100></textarea>
        </li>
        </div>
    </ol>
    
</form>

</div>
</div>
</body>
</html>