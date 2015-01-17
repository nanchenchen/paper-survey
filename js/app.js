function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
(function(){
    var app = angular.module('questionnaire', []);
    app.controller('FormController', ['$scope', '$timeout', function($scope, $timeout){
        var ctrl = this;
        $scope.formChanged = 0;
        $scope.analysis = {};
        $.ajax({
            url: "get_paper_data.php",
            type: "GET",
            data: {id: getUrlVars()["id"]},
            async: false,
        })
         .done(function(response){
            $scope.paper = response;
            $scope.paper.attachments = "pdfs/" + encodeURIComponent($scope.paper.attachments);  
            $scope.finished = response.finished;           
            $("#pdf_file").prop("data", $scope.paper.attachments);
            $("#open_pdf").prop("href", $scope.paper.attachments);
        });
        $.ajax({
            url: "get_paper_analysis.php",
            type: "GET",
            data: {id: getUrlVars()["id"]},
            async: false,
        })
         .done(function(response){
            //debugger;
            if ( typeof(response.user) !== "undefined" )
                $scope.last_user = response.user;
            if ( typeof(response.timestamp) !== "undefined" )
                $scope.last_time = response.timestamp;
            if ( typeof(response.analysis) !== "undefined" )
                $scope.analysis = JSON.parse(response.analysis);           
        });   
        $scope.isTarget = function(){
            if ( typeof($scope.analysis.user) === "undefined" || typeof($scope.analysis.is_target) === "undefined" ) return false;
            else return $scope.analysis.is_target == 1;
        };
        
        $scope.users = ["Michael", "Jeff", "Zening", "Rafal", "Nan-Chen", "Sanny"];
        $scope.data_sources = ["Twitter", "Facebook", "Chat", "Emails", "Blogs", "Forums"];
        $scope.other_aspects = ["Profiles / Users / People", "Connections / Networks"];
        $scope.primary_concerns = ["Offline social phenomena","Online social phenomena", "Computational data processing technique", "Research methodology"];
        $scope.methods_us = [ 
            {name: "modeling", desc: "Modeling (e.g. machine learning models, topic models...)"}, 
            {name: "stats", desc: "Statistical analysis (e.g. descriptive statistics, comparing two subgroups)"}, 
            {name: "sna", desc: "Social network analysis (e.g. centrality)"}, 
            {name: "human", desc: "Human interpretation (e.g. qualitative coding, close reading)"}];
        $scope.result_presentations = ["Simple charts and graphs", "More complex visualizations", "Tables", "Quotations or excerpts", "Statistical results", "Narrative accounts"];
        $scope.isFinished = function(){
            return $scope.finished == 1 || $scope.finished == true;
        };
        $scope.submit = function() {
            //debugger;
            if ( $scope.formChanged == 0 ) return;
            if ( typeof($scope.analysis.user) === "undefined" ){
                alert("Please choose who you are!");
                return;
            }
            $scope.analysis.paper_id = getUrlVars()["id"];
            $.ajax({
                url: "save_analysis.php",
                type: "POST",
                data: JSON.stringify($scope.analysis),
                async: false,
            })
             .done(function(response){
                //console.log(response);
                //debugger;
                if ( typeof(response.user) !== "undefined" )
                    $scope.last_user = response.user;
                if ( typeof(response.timestamp) !== "undefined" )
                    $scope.last_time = response.timestamp;
                $scope.formChanged = 0;
                $timeout(function() {
                    $scope.$apply();
                }, 1000);
            });
            
        };
        $scope.done = function(finished) {
            $scope.finished = finished;
            $.ajax({
                url: "finish_analysis.php",
                type: "POST",
                data: {"id": getUrlVars()["id"], "finished": finished},
                async: false,
            })
             .done(function(response){
                $scope.submit();
                $timeout(function() {
                    $scope.$apply();
                }, 1000);
            });
        };
        
        $(function(){
            $( "input" ).change(function() {        
                $scope.formChanged += 1;
            });
            $( "textarea" ).change(function() {        
                $scope.formChanged += 1;
            });
        });
        $scope.$watch(function($scope){ return $scope.formChanged}, function(value){
            //debugger;
            if ( $scope.formChanged && typeof($scope.analysis.user) !== "undefined" && typeof($scope.analysis.is_target) !== "undefined" )
                $scope.submit();
        });
    }]);
   
})();