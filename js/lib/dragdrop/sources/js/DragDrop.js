(function() {
    var DragDrop = (function () {
        function Class () {

            function Constructor () {
                var _this = this;

                var $questionText = $('#questionText'),
                    $checkButton  = $('#linden_CheckButton').attr('disabled', true).bind('click', checkButtonClickHandler),
                    $showAnswer   = $('#linden_ShowAnswerButton').css('opacity', 0).attr('disabled', true).bind('click', showAnswerButtonClickHandler),
                    $tryAgain     = $('#linden_TryAgainButton').css('opacity', 0).attr('disabled', true).bind('click', tryAgainButtonClickHandler),
                    dragObjOrder,
                    isDropEmpty = [false, false],
                    whichDrag   = [0,0];


                this.initialize = function () {
                    $questionText.html("İşletme 14.06.20XX tarihinde kasasında bulunan 14.500 TL’yi banka hesabına yatırmıştır. Bu işlemle ilgili aşağıdaki günlük defter kaydında boş bulanan kutucukları uygun olan hesapları taşıyarak doldurunuz. Gönder düğmesine basınız.");

                    var _obj = null;
                    for (var i = 0; i < 9; i++) {
                        _obj = $('#linden-dragItem_' + i);
                        _obj.data('x', _obj.css('left'));
                        _obj.data('y', _obj.css('top'));
                        _obj.data('active', true);
                    }


                    $(".linden-dragItems").draggable({
                        containment: '#linden_MainContainer',
                        stack      : '.linden-dragItems',
                        snap       : '#content',
                        revert     : 'invalid',
                        start      : dragStarted
                    });

                    $( ".linden-dropItems").droppable({ drop: dropEventHandler });
                };


                function dragStarted(event) {
                    dragObjOrder = Utilities.getGroupOrder($(this));
                }

                function dropEventHandler(event, ui) {
                    console.info(ui.draggable);
                    console.info(event.target);

                    if (!isDropEmpty[Utilities.getGroupOrder(event.target)]) {
                        ui.draggable.css({left: $(event.target).css('left'), top: $(event.target).css('top')});
                        isDropEmpty[Utilities.getGroupOrder(event.target)] = true;
                        whichDrag[Utilities.getGroupOrder(event.target)] = Utilities.getGroupOrder(ui.draggable);
                        ui.draggable.draggable({ disabled: true }).data('active', false);
                    }
                    else {
                        ui.draggable.css({left: ui.draggable.data('x'), top:  ui.draggable.data('y')});
                    }

                    if(isDropEmpty.every(isTrue)) {
                        $checkButton.attr('disabled', false);
                    }
                }

                function checkButtonClickHandler(e) {
                    $checkButton.attr('disabled', true);
                    $showAnswer.attr('disabled', false).css('opacity', 1);
                    $tryAgain.attr('disabled', false).css('opacity', 1);

                    var correct = [4,6];

                    for (var i = 0; i < whichDrag.length; i++) {
                        if(whichDrag[i] === correct[i]) {
                            $("#linden-dragItem_" + whichDrag[i]).css('background-color', "green");
                        }
                        else {
                            //$("#linden-dragItem_" + whichDrag[i]).css({left: $("#linden-dragItem_" + whichDrag[i]).data('x'), top:  $("#linden-dragItem_" + whichDrag[i]).data('y')});
                            $("#linden-dragItem_" + whichDrag[i]).css('background-color', "red");
                        }

                        isDropEmpty[i] = false;
                        whichDrag[i] = 0;
                    }

                    var _obj;
                    for (var i = 0; i < 9; i++) {
                        _obj = $('#linden-dragItem_' + i);
                        if(_obj.data('active')) {
                            _obj.draggable({ disabled: true }).data('active', false);
                        }
                    }
                }

                function isTrue (element, index, array) {
                     return element === true;
                }

                function showAnswerButtonClickHandler() {
                    $showAnswer.attr('disabled', true);
                    var correct = [4,6];

                    var _obj;
                    for (var i = 0; i < 9; i++) {
                        _obj = $('#linden-dragItem_' + i);
                        _obj.css({left: _obj.data('x'), top: _obj.data('y'), background: "#139688"});
                    }

                    for (var i = 0; i < whichDrag.length; i++) {
                        if(!isDropEmpty[i]) {
                            $("#linden-dragItem_" + correct[i]).css({left: $("#linden-dropItem_" + i).css('left'), top:  $("#linden-dropItem_" + i).css('top'), background: "green"});
                        }
                    }
                }

                function tryAgainButtonClickHandler(e) {
                    $checkButton.attr('disabled', true);
                    $showAnswer.attr('disabled', true).css('opacity', 0);
                    $tryAgain.attr('disabled', true).css('opacity', 0);

                    var _obj;
                    for (var i = 0; i < 9; i++) {
                        _obj = $('#linden-dragItem_' + i);
                        _obj.css({left: _obj.data('x'), top: _obj.data('y'),background: "#139688"});

                        if(!_obj.data('active')) {
                            _obj.draggable({ disabled: false }).data('active', true);
                        }
                    }

                    for (var i = 0; i < whichDrag.length; i++) {
                        isDropEmpty[i] = false;
                        whichDrag[i] = 0;
                    }
                }
            }
            Constructor.apply(this, arguments);
        }
        return Class;
    })();

    //Utilities........................................................................................................
    var Utilities = (function () {
        function Utilities() {}

        Utilities.getObjectByParam = function(needle, haystack, param) {
            for(var i = 0; i < haystack.length; i++) {
                if(haystack[i][param] == needle)
                    return haystack[i];
            }
            return null;
        };

        Utilities.getGroupOrder = function (obj){
            var strArr = $(obj).attr('id').split("_");
            return parseInt(strArr[1], 10);
        };

        Utilities.createDOM = function (_type, _id, _class) {
            var dom = $(document.createElement(_type));
            if (typeof _id != "undefined" && _id.trim() != "") dom.attr("id", _id.trim());
            if (typeof _class != "undefined" && _class.trim() != "") dom.attr("class", _class.trim());

            return dom;
        };

        Utilities.addDOM = function (_type, _container, _id, _class) {
            var dom = $(document.createElement(_type));
            if (typeof _id != "undefined" && _id.trim() != "") dom.attr("id", _id.trim());
            if (typeof _class != "undefined" && _class.trim() != "") dom.attr("class", _class.trim());

            _container.append(dom);

            return dom;
        };

        Utilities.trace = function(msg) {
            console.info('-----> ' + msg);
        };

        return Utilities;
    })();

    $( document ).ready(function() {
        var dragDrop = new DragDrop();
        dragDrop.initialize();
    });
})();