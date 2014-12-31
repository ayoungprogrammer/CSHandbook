(function(){
    if ($(window).width()>800){
        $('nav ul li').mouseenter(function(){
            var nestedNav =  $(this).find('ul');
            nestedNav.css({
                'margin-left': -parseInt(nestedNav.outerWidth()) / 2,
            });
            nestedNav.parent('div').css({
                'padding-top':15,
                'height':100
            });
        });
    }
    else{
        $('nav ul div').hide();
        $('nav ul li').on('click', function(){
            var targetItem = $(this);
            targetItem.children('div').slideToggle();
            targetItem.siblings('li').children('div').slideUp();
        });
    }

    var topics = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit: 10,
        prefetch: {
            url: 'topics',
            ttl_ms: 5000,
            filter: function(list){
                return $.map(list,function(topic){return {name: topic}; });
            }
        }
    });
    topics.initialize();

    $('#searchBar').typeahead({
        hint: true,
        highlight: true,
    },{
        name: 'topics',
        displayKey: 'name',
        source: topics.ttAdapter()
    });

    $('#searchBar').keypress(function(e){
        if(e.keyCode == 13){
            var topic = $('#searchBar').val().replace(/ /g,"_");
            window.location.href = "./"+topic;
        }
    });

    $('#searchBar').on('typeahead:selected',function(e){
        var topic = $('#searchBar').val().replace(/ /g,"_");
        window.location.href = "./"+topic;
    });

})();