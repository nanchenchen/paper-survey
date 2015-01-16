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
    app.controller('FormController', function(){
        var ctrl = this;
        ctrl.analysis = {};
        $.ajax({
            url: "get_paper_data.php",
            type: "GET",
            data: {id: getUrlVars()["id"]},
            async: false,
        })
         .done(function(response){
            ctrl.paper = response;
            ctrl.paper.attachments = "pdfs/" + encodeURIComponent(ctrl.paper.attachments);          
            $("#pdf_file").prop("data", ctrl.paper.attachments);
            $("#open_pdf").prop("href", ctrl.paper.attachments);
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
                ctrl.last_user = response.user;
            if ( typeof(response.timestamp) !== "undefined" )
                ctrl.last_time = response.timestamp;
            if ( typeof(response.analysis) !== "undefined" )
                ctrl.analysis = JSON.parse(response.analysis);           
        });   
        ctrl.isTarget = function(){
            if ( typeof(ctrl.analysis.is_target) === "undefined" ) return false;
            else return ctrl.analysis.is_target == 1;
        };
        
        ctrl.users = ["Michael", "Jeff", "Zening", "Rafal", "Nan-Chen", "Sanny"];
        ctrl.data_sources = ["Twitter", "Facebook", "Chat", "Emails", "Blogs", "Forums"];
        ctrl.other_aspects = ["Profiles / Users / People", "Connections / Networks"];
        ctrl.primary_concerns = ["Offline social phenomena","Online social phenomena", "Computational data processing technique", "Research methodology"];
        ctrl.methods_us = [ 
            {name: "modeling", desc: "Modeling (e.g. machine learning models, topic models...)"}, 
            {name: "stats", desc: "Statistical analysis (e.g. descriptive statistics, comparing two subgroups)"}, 
            {name: "sna", desc: "Social network analysis (e.g. centrality)"}, 
            {name: "human", desc: "Human interpretation (e.g. qualitative coding, close reading)"}];
        ctrl.result_presentations = ["Simple charts and graphs", "More complex visualizations", "Tables", "Quotations or excerpts", "Statistical results", "Narrative accounts"];
        
        ctrl.submit = function() {
            //debugger;
            if ( typeof(ctrl.analysis.user) === "undefined" ){
                alert("Please choose who you are!");
                return;
            }
            ctrl.analysis.paper_id = getUrlVars()["id"];
            $.ajax({
                url: "save_analysis.php",
                type: "POST",
                data: JSON.stringify(ctrl.analysis),
                async: false,
            })
             .done(function(response){
                //console.log(response);
                //debugger;
            });
            
        };
    });
    
})();