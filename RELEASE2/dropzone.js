// the following line already exists
if (this.options.addRemoveLinks) {

    /* NEW PART */
    file._openLink = Dropzone.createElement("<a class=\"dz-open\" href=\"javascript:undefined;\">Open File</a>");
    file._openLink.addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      window.open("lennyface.260mb.net"+file.name);
    });
    /* END OF NEW PART */

    // the following lines already exist
    file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\">" + this.options.dictRemoveFile + "</a>");
    file._removeLink.addEventListener("click", function(e) {