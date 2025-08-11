// Need a comment here; trust me on this one

dhtmlXGridObject.prototype._bp_attachHeader = dhtmlXGridObject.prototype.attachHeader;
dhtmlXGridObject.prototype.attachHeader = function(values,style,_type){
          this.doColResize = function(ev,el,startW,x,tabW){
                        el.style.cursor = "E-resize";
                        this.resized = el;
                        var fcolW = startW + (ev.clientX-x);
                        var wtabW = tabW + (ev.clientX-x)
                                if (!(this.callEvent("onResize",[el._cellIndex,fcolW,this]))) return;
                                if (el.colSpan>1){
                                    var a_sizes=new Array();
                                    for (var i=0; i<el.colSpan; i++)
                                        a_sizes[i]=Math.round(fcolW*this.hdr.rows[0].childNodes[el._cellIndexS+i].offsetWidth/el.offsetWidth);
                                    for (var i=0; i<el.colSpan; i++)
                                        this._setColumnSizeR(el._cellIndexS+i*1,a_sizes[i]);
                                }
                        else
                                this._setColumnSizeR(el._cellIndex,fcolW);
                                this.doOnScroll(0,1);
                            this.objBuf.childNodes[0].style.width = "";
                            if (_isOpera || _isFF) this.setSizes();
                     }
    this.attachHeader=this._bp_attachHeader;
    return this.attachHeader(values,style,_type);
}