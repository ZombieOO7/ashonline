
(function() {
    let currentPageIndex = 0;
    let pageMode = 1;
    let cursorIndex = Math.floor(currentPageIndex / pageMode);
    let pdfInstance = null;
    let totalPagesCount = 0;

    const viewport = document.querySelector("#viewport");
    window.initPDFViewer = function(index,pdfURL) {
      pdfjsLib.getDocument(pdfURL).then(pdf => {
        pdfInstance = pdf;
        totalPagesCount = pdf.numPages;
        // initPager(index);
        // initPageMode(index);
        render(index);
      });
    };
  
    function onPagerButtonsClick(event) {
      const action = event.target.getAttribute("data-pager");
      var index = event.target.getAttribute("data-index");
      if (action === "prev") {
        if (currentPageIndex === 0) {
          return;
        }
        currentPageIndex -= pageMode;
        if (currentPageIndex < 0) {
          currentPageIndex = 0;
        }
        render(index);
      }
      if (action === "next") {
        if (currentPageIndex === totalPagesCount - 1) {
          return;
        }
        currentPageIndex += pageMode;
        if (currentPageIndex > totalPagesCount - 1) {
          currentPageIndex = totalPagesCount - 1;
        }
        render(index);
      }
    }
    function initPager(index) {
      const pager = document.querySelector("#pager"+index);
      pager.addEventListener("click", onPagerButtonsClick);
      return () => {
        pager.removeEventListener("click", onPagerButtonsClick);
      };
    }
  
    function onPageModeChange(event) {
      pageMode = Number(event.target.value);
      var index = event.target.getAttribute("data-index");
      render(index);
    }
    function initPageMode(index) {
      const input = document.querySelector("#page-mode"+index+" input");
      input.setAttribute("max", totalPagesCount);
      input.addEventListener("change", onPageModeChange);
      return () => {
        input.removeEventListener("change", onPageModeChange);
      };
    }
  
    function render(index=null) {
      cursorIndex = Math.floor(currentPageIndex / pageMode);
      const startPageIndex = cursorIndex * pageMode;
    //   const endPageIndex = startPageIndex + pageMode < totalPagesCount ? startPageIndex + pageMode - 1 : totalPagesCount - 1;
      const endPageIndex = totalPagesCount - 1;
  
      const renderPagesPromises = [];
      for (let i = startPageIndex; i <= endPageIndex; i++) {
        renderPagesPromises.push(pdfInstance.getPage(i + 1));
      }
  
      Promise.all(renderPagesPromises).then(pages => {
        const pagesHTML = `<div style="width: ${ pageMode > 1 ? "50%" : "100%" }"><canvas></canvas></div>`.repeat(pages.length);
        document.querySelector("#viewport"+index).innerHTML = pagesHTML;
        $.each(pages,function(key,page){
            renderPage(page,index)
        })
      });
    }
  
    function renderPage(page,index) {
        let pdfViewport = page.getViewport(1);
        const container = document.querySelector("#viewport"+index).children[page.pageIndex - cursorIndex * pageMode];
        pdfViewport = page.getViewport(container.offsetWidth / pdfViewport.width);
        const canvas = container.children[0];
        const context = canvas.getContext("2d");
        canvas.height = pdfViewport.height;
        canvas.width = pdfViewport.width;

        page.render({
            canvasContext: context,
            viewport: pdfViewport
        },index);
    }
})();
$(document).on('click','.nav-item',function(){
    initializePdf();
})
function initializePdf(){
  if($('.pdfApp').length > 0){
    $('.pdfApp').each(function(){
        var index = $(this).attr('data-index');
        var src = $(this).attr('data-src');
        initPDFViewer(index,src);
    })
  }
  if($('#examData').find('.pdfApp').length > 0){
    $('#examData').find('.pdfApp').each(function(){
        var index = $(this).attr('data-index');
        var src = $(this).attr('data-src');
        initPDFViewer(index,src);
    })
  }
  if($('#examData').find('.pdfApp').length > 0){
    $('#examData').find('.pdfApp').each(function(){
        var index = $(this).attr('data-index');
        var src = $(this).attr('data-src');
        initPDFViewer(index,src);
    })
  }
}