/**
 * Javascript for dualselect element handling
 *
 * Contains methods for moving options between selects and also for selecting
 * all options of 'to' select on form submit. This is necessary since
 * unselected options obviously won't send any values.
 *
 * $Id: dualselect.js 310525 2011-04-26 18:42:03Z avb $
 */

qf.elements.dualselect = (function() {

    function addOption(box, option, keepSorted)
    {
        if (!keepSorted || 0 == box.options.length
            || option.text > box.options[box.options.length-1].text
        ) {
            box.options[box.options.length] = option;

        } else if (option.text < box.options[0].text) {
            try {
                // IE way
                box.add(option, 0);
            } catch (e) {
                // Standards way
                box.add(option, box.options[0]);
            }

        } else {
            for (var i = box.options.length - 1; i >= 0; i--) {
                if (option.text >= box.options[i].text) {
                    try {
                        // IE way
                        box.add(option, i + 1);
                    } catch (e) {
                        // Standards way
                        box.add(option, box.options[i + 1]);
                    }
                    break;
                }
            }
        }
        return true;
    };
    
    return {
        init: function(baseId, keepSorted)
        {
            var dest = document.getElementById(baseId + '-to');
            qf.events.addListener(dest.form, 'submit', function() {
                for (var option, i = 0; option = dest.options[i]; i++) {
                    option.selected = true;
                }
            });
            qf.events.addListener(document.getElementById(baseId + '-fromto'), 'click', function(event) {
                qf.elements.dualselect.moveOptions(baseId + '-from', baseId + '-to', keepSorted);
                qf.Validator.liveHandler(event);
            });
            qf.events.addListener(document.getElementById(baseId + '-tofrom'), 'click', function(event) {
                qf.elements.dualselect.moveOptions(baseId + '-to', baseId + '-from', keepSorted);
                qf.Validator.liveHandler(event);
            });
        },

        moveOptions: function(srcId, destId, keepSorted)
        {
            var src  = document.getElementById(srcId);
            var dest = document.getElementById(destId);

            for (var i = src.options.length - 1; i >= 0; i--) {
                if (src.options[i].selected) {
                    var option = src.options[i];
                    src.remove(i);
                    option.selected = false;
                    addOption(dest, option, keepSorted);
                }
            }
        },

        getValue: function (destId)
        {
            var values = [], el = document.getElementById(destId);
            if (el.disabled) {
                return null;
            }
            for (var option, i = 0; option = el.options[i]; i++) {
                values.push(option.value);
            }
            return values;
        }
    };
})();
