jQuery (function ($){
    $('.ui-ghost-text').focus(function () {
        var $this = $(this),
            ghostText = $this.data('ghost-text');

        if ($this.val() === ghostText) {
            $this.removeClass('ui-ghost-text');
            $this.val('');

            if($this.hasClass('ui-password')) {
                $clone = $this.clone(true).attr('type', 'password');

                $this.replaceWith($clone);

                $clone.focus();
            }
        }
    }).blur(function () {
        var $this = $(this),
            ghostText = $this.data('ghost-text');

        if ($this.val().length === 0) {
            $this.addClass('ui-ghost-text');
            $this.val(ghostText);

            if ($this.hasClass('ui-password')) {
                $clone = $this.clone(true).attr('type', 'text').val(ghostText);

                $this.replaceWith($clone);
            }
        }
    });
    
    $('.ui-typeahead').each(function () {
        var $this = $(this),
            $placeholder = $('<ul>').addClass('ui-placeholder'),        
            data = $this.data('source');
        
        
        for(var i = 0, len = data.length; i < len; ++i) {
            $placeholder.append($('<li>').html(data[i]));
        }
        
        $placeholder.hide();
        $this.after($placeholder);
        
        $placeholder.find('li').click(function () {
            $this.val(this.innerHTML);
            $placeholder.hide();
        });
    }).keydown(function (e) {
        var $this = $(this),
            $placeholder = $this.next('.ui-placeholder'),
            lastChar = String.fromCharCode(e.keyCode).toLowerCase(),
            keyword = this.value + lastChar;
        
        switch (e.keyCode) {
            case 8:
                keyword = keyword.substr(0, keyword.length - 2);
                $placeholder.find('li').show();
                $placeholder.hide();
                
                break;
            case 38: // KEY_UP
                
                break;
            case 40: // KEY_DOWN
                break;
            default:
                if (keyword.length > 0) {
                    $placeholder.show().
                        find('li').each(function () {
                            if (this.innerHTML.toLowerCase().indexOf(keyword) !== 0) {
                                $(this).hide();
                            }
                        });
                }
                
                break;
        }        
    });

    $('.ui-group-box.collapsible').
        find('.collapse-toggle').
            click(function() {
                $(this).parents('.ui-group-box.collapsible').
                    slice(0, 1).
                    slideToggle(function () {
                        $(this).toggleClass('collapse');
                        $(this).show();
                    });
            });
});