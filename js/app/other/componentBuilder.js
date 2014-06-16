$.widget( "nmk.componentBuilder", {
 
    options: {
        title: "Component Builder",
        icon: "<i class='icon-m-video'></i>",
        modal: false,
        top : "200px",
        left : "200px",
        width:"600px",
        height:"480px",
        "z-index":9999999,
        showBtn: true,
        btnTitle: "Insert",
        onBtnClick : function (){},
        component: null,
        beforeClose : function () {},
        onClose : function (){},
    },
 
    _create: function() {
        var that = this;

        this.element
            .addClass('popup')
            .css({
                "top"       :   this.options.top,
                "left"      :   this.options.left,
                "width"     :   this.options.width,
                "height"    :   this.options.height,
                "z-index"   :   this.options["z-index"],
                "position"  :   'absolute',
                "display"   :   'inline-block'
            })    
            ;

        this.header = $("<div class='popup-header'></div>")
            .css({
                "position": "absolute",
                "top": "0",
                "width": "100%",
                "padding-top": "10px"
            })
            .append(this.options.icon)
            .append("&nbsp;")
            .append("&nbsp;")
            .append(this.options.title)
            .appendTo(this.element);
        
        this.closeBtn = $ ("<i class='icon-close size-10 popup-close-button'></i>")
            .appendTo(this.header)
            .click(function(event){
                event.preventDefault();
                if(that.options.beforeClose() === false) return;
                    that.close();
            })

        this.innerWrap = $("<div class='gallery-inner-holder'></div>")
            .css({'width':'100%','height':'100%',overflow:'hidden','padding':'50px 20px'})
            .appendTo(this.element);
        
        this.inner = $("<div>")
            .css({'width':'100%',overflow:'scroll'})
            .appendTo(this.innerWrap);

        this.footer = $("<div class='popup-footer'></div>")
            .appendTo(this.element)
            .css({
                "position": "absolute",
                "bottom": "0",
                "width": "100%",
                "padding-bottom": "20px"
            });

        this.button = $("<a href='' class='btn btn-info' >"+ this.options.btnTitle+"</a>")
            .appendTo(this.footer)
            .click(function(event){
                event.preventDefault();
                if(that.options.onBtnClick() === false) return;
                    that.close();
            });


        this.element
            .resizable()
            .draggable();


        return this;

    },
 
    _setOption: function( key, value ) {
        this.options[ key ] = value;
        this._update();
    },
 
    _update: function() {
        var progress = this.options.value + "%";
        this.element.text( progress );
        if ( this.options.value === 100 ) {
            this._trigger( "complete", null, { value: 100 } );
        }
    },

    close: function(){
        this.options.onClose();
        this.destroy();
    },
 
    destroy: function() {
        this.element.remove();
        // Call the base destroy function.
        $.Widget.prototype.destroy.call( this );
    }
 
});