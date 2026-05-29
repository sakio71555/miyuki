(function ($) {
  function getBox($element) {
    return $element.closest('.miyuki-works-admin, .miyuki-works-easy-form');
  }

  function getImageContext($element) {
    var $field = $element.closest('.miyuki-image-upload-field');
    return $field.length ? $field : getBox($element);
  }

  function getGalleryContext($element) {
    var $field = $element.closest('.miyuki-gallery-upload-field');
    return $field.length ? $field : getBox($element);
  }

  function getAdminConfig() {
    if (window.miyukiWorksAdmin) {
      return window.miyukiWorksAdmin;
    }

    if (typeof miyukiWorksAdmin !== 'undefined') {
      return miyukiWorksAdmin;
    }

    return {};
  }

  function uniqueIds(ids) {
    return ids.filter(function (id, index) {
      return id && ids.indexOf(id) === index;
    });
  }

  function galleryEmptyHtml() {
    return '<div class="miyuki-gallery-empty"><strong>写真をまとめてドラッグ</strong><span>大きい写真も自動で軽くして、順番に追加します。</span></div>';
  }

  function mainEmptyHtml() {
    return '<div class="miyuki-easy-empty"><strong>ここに画像をドラッグ</strong><span>容量オーバー防止のため、自動で軽くしてからアップします。</span></div>';
  }

  function setUploadStatus($target, message) {
    $target.find('.miyuki-upload-status').remove();
    $target.append('<div class="miyuki-upload-status">' + $('<div>').text(message).html() + '</div>');
  }

  function clearUploadStatus($target) {
    $target.find('.miyuki-upload-status').remove();
  }

  function getUploadLimit() {
    var limit = parseInt(getAdminConfig().maxUploadBytes, 10);

    if (!limit || Number.isNaN(limit)) {
      limit = 2 * 1024 * 1024;
    }

    return limit;
  }

  function getTargetBytes() {
    return Math.max(700 * 1024, Math.min(1600 * 1024, Math.floor(getUploadLimit() * 0.78)));
  }

  function createJpegName(file) {
    var name = file.name || 'works-image';
    return name.replace(/\.[^.]+$/, '') + '.jpg';
  }

  function loadImage(file) {
    var deferred = $.Deferred();
    var image = new Image();
    var url = URL.createObjectURL(file);

    image.onload = function () {
      URL.revokeObjectURL(url);
      deferred.resolve(image);
    };

    image.onerror = function () {
      URL.revokeObjectURL(url);
      deferred.reject('画像を読み込めませんでした。');
    };

    image.src = url;

    return deferred.promise();
  }

  function canvasToBlob(canvas, quality) {
    var deferred = $.Deferred();

    canvas.toBlob(function (blob) {
      if (blob) {
        deferred.resolve(blob);
      } else {
        deferred.reject('画像の軽量化に失敗しました。');
      }
    }, 'image/jpeg', quality);

    return deferred.promise();
  }

  function drawResizedCanvas(image, maxSize) {
    var ratio = Math.min(1, maxSize / Math.max(image.naturalWidth, image.naturalHeight));
    var canvas = document.createElement('canvas');
    var width = Math.max(1, Math.round(image.naturalWidth * ratio));
    var height = Math.max(1, Math.round(image.naturalHeight * ratio));
    var context = canvas.getContext('2d');

    canvas.width = width;
    canvas.height = height;
    context.fillStyle = '#ffffff';
    context.fillRect(0, 0, width, height);
    context.drawImage(image, 0, 0, width, height);

    return canvas;
  }

  function compressWithOptions(file, image, options, index) {
    var deferred = $.Deferred();
    var option = options[index];

    if (!option) {
      deferred.resolve({
        blob: file,
        name: file.name,
        compressed: false
      });
      return deferred.promise();
    }

    canvasToBlob(drawResizedCanvas(image, option.maxSize), option.quality).done(function (blob) {
      if (blob.size <= getTargetBytes() || index === options.length - 1) {
        if (blob.size < file.size || file.size > getUploadLimit()) {
          deferred.resolve({
            blob: blob,
            name: createJpegName(file),
            compressed: true
          });
        } else {
          deferred.resolve({
            blob: file,
            name: file.name,
            compressed: false
          });
        }
        return;
      }

      compressWithOptions(file, image, options, index + 1).done(deferred.resolve).fail(deferred.reject);
    }).fail(deferred.reject);

    return deferred.promise();
  }

  function prepareUploadFile(file) {
    var deferred = $.Deferred();
    var canCompress = /^image\/(jpeg|jpg|png|webp)$/i.test(file.type);

    if (!canCompress) {
      deferred.resolve({
        blob: file,
        name: file.name,
        compressed: false
      });
      return deferred.promise();
    }

    loadImage(file).done(function (image) {
      var options = [
        { maxSize: 2000, quality: 0.84 },
        { maxSize: 1800, quality: 0.76 },
        { maxSize: 1600, quality: 0.68 },
        { maxSize: 1400, quality: 0.62 },
        { maxSize: 1200, quality: 0.58 }
      ];

      compressWithOptions(file, image, options, 0).done(deferred.resolve).fail(deferred.reject);
    }).fail(deferred.reject);

    return deferred.promise();
  }

  function normalizeAttachment(attachment) {
    attachment.sizes = attachment.sizes || {};
    return attachment;
  }

  function setMainImage($box, attachment) {
    attachment = normalizeAttachment(attachment);
    var image = attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url ? attachment.sizes.medium.url : attachment.url;
    var alt = attachment.alt || attachment.title || '';

    $box.find('.miyuki-main-image-input').val(attachment.id);
    $box.find('.miyuki-main-image-preview').html(
      '<img src="' + image + '" alt="' + $('<div>').text(alt).html() + '">'
    );
  }

  function updateGalleryInput($box) {
    var ids = [];
    var $preview = $box.find('.miyuki-gallery-preview').first();
    var $input = $box.find('.miyuki-gallery-input').first();

    $preview.find('.miyuki-gallery-item').each(function () {
      ids.push($(this).data('id').toString());
    });

    $input.val(uniqueIds(ids).join(','));

    if ($preview.find('.miyuki-gallery-item').length === 0 && $preview.find('.miyuki-gallery-empty').length === 0) {
      $preview.html(galleryEmptyHtml());
    } else if ($preview.find('.miyuki-gallery-item').length > 0) {
      $preview.find('.miyuki-gallery-empty').remove();
    }
  }

  function createGalleryItem(attachment) {
    attachment = normalizeAttachment(attachment);
    var image = attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url ? attachment.sizes.thumbnail.url : attachment.url;
    var alt = attachment.alt || attachment.title || '';

    return $(
      '<div class="miyuki-gallery-item" data-id="' + attachment.id + '">' +
      '<img src="' + image + '" alt="' + $('<div>').text(alt).html() + '">' +
      '<button type="button" class="miyuki-gallery-remove" aria-label="写真を削除">×</button>' +
      '</div>'
    );
  }

  function escapeHtml(value) {
    return $('<div>').text(value || '').html();
  }

  function addGalleryAttachment($box, attachment) {
    var $preview = $box.find('.miyuki-gallery-preview').first();
    var currentIds = ($box.find('.miyuki-gallery-input').first().val() || '').split(',').filter(Boolean);
    var id = attachment.id.toString();

    if (currentIds.indexOf(id) === -1) {
      $preview.find('.miyuki-gallery-empty').remove();
      $preview.append(createGalleryItem(attachment));
      updateGalleryInput($box);
    }
  }

  function uploadPreparedImage(uploadFile) {
    var data = new FormData();
    var config = getAdminConfig();

    data.append('action', 'miyuki_works_upload_image');
    data.append('nonce', config.nonce);
    data.append('file', uploadFile.blob, uploadFile.name);

    return $.ajax({
      url: config.ajaxUrl,
      method: 'POST',
      data: data,
      processData: false,
      contentType: false
    }).then(function (response) {
      if (!response || !response.success) {
        var message = response && response.data && response.data.message ? response.data.message : 'アップロードに失敗しました。';
        return $.Deferred().reject(message).promise();
      }

      return response.data;
    });
  }

  function uploadFilesSequential($target, files, onAttachment) {
    var deferred = $.Deferred();
    var index = 0;
    var results = [];

    function next() {
      if (index >= files.length) {
        deferred.resolve(results);
        return;
      }

      setUploadStatus($target, (index + 1) + '/' + files.length + '枚目を軽量化中...');

      prepareUploadFile(files[index]).done(function (uploadFile) {
        var label = uploadFile.compressed ? '軽量化してアップロード中...' : 'アップロード中...';
        setUploadStatus($target, (index + 1) + '/' + files.length + '枚目を' + label);

        uploadPreparedImage(uploadFile).done(function (attachment) {
          results.push(attachment);
          onAttachment(attachment);
          index += 1;
          next();
        }).fail(deferred.reject);
      }).fail(deferred.reject);
    }

    next();

    return deferred.promise();
  }

  function filesFromEvent(event) {
    return Array.prototype.slice.call(event.originalEvent.dataTransfer.files || []).filter(function (file) {
      return file.type && file.type.indexOf('image/') === 0;
    });
  }

  function bodyEditorIds() {
    return ['miyuki_news_body', 'miyuki_event_body'];
  }

  function getBodyEditorWrap(editorId) {
    return $('#wp-' + editorId + '-wrap');
  }

  function getBodyEditor(editorId) {
    if (window.tinymce && window.tinymce.get(editorId)) {
      return window.tinymce.get(editorId);
    }

    return null;
  }

  function getBodyEditorBookmark(editorId) {
    var editor = getBodyEditor(editorId);

    if (!editor || editor.isHidden()) {
      return null;
    }

    try {
      return editor.selection.getBookmark(2, true);
    } catch (error) {
      return null;
    }
  }

  function insertHtmlIntoTextarea(textarea, html) {
    var value = textarea.value || '';
    var start = typeof textarea.selectionStart === 'number' ? textarea.selectionStart : value.length;
    var end = typeof textarea.selectionEnd === 'number' ? textarea.selectionEnd : start;
    var before = value.slice(0, start);
    var after = value.slice(end);
    var nextValue = before + html + after;

    textarea.value = nextValue;
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + html.length;
    $(textarea).trigger('change');
  }

  function insertHtmlIntoBodyEditor(editorId, html, bookmark) {
    var editor = getBodyEditor(editorId);

    if (editor && !editor.isHidden()) {
      editor.focus();

      if (bookmark) {
        try {
          editor.selection.moveToBookmark(bookmark);
        } catch (error) {
          // If the editor lost the exact drag position, insert at the current cursor.
        }
      }

      editor.execCommand('mceInsertContent', false, html);
      editor.save();
      return;
    }

    var textarea = document.getElementById(editorId);
    if (textarea) {
      insertHtmlIntoTextarea(textarea, html);
    }
  }

  function imageHtmlForEditor(attachment) {
    attachment = normalizeAttachment(attachment);
    var src = attachment.url;
    var alt = attachment.alt || attachment.title || '';

    return '<p><img class="alignnone size-full wp-image-' + attachment.id + '" src="' + escapeHtml(src) + '" alt="' + escapeHtml(alt) + '"></p>';
  }

  function handleBodyEditorDrop(event, editorId) {
    event.preventDefault();
    event.stopPropagation();

    var files = filesFromEvent(event);
    var $target = getBodyEditorWrap(editorId);
    var bookmark = getBodyEditorBookmark(editorId);

    $target.removeClass('is-dragover');

    if (!files.length) {
      setUploadStatus($target, '画像ファイルをドラッグしてください。');
      return;
    }

    uploadFilesSequential($target, files, function (attachment) {
      insertHtmlIntoBodyEditor(editorId, imageHtmlForEditor(attachment), bookmark);
      bookmark = null;
    }).done(function () {
      clearUploadStatus($target);
    }).fail(function (message) {
      setUploadStatus($target, typeof message === 'string' ? message : '本文への画像追加に失敗しました。');
    });
  }

  function bindTinyMceBodyDrop(editorId) {
    var editor = getBodyEditor(editorId);

    if (!editor || editor.miyukiBodyDropBound) {
      return;
    }

    editor.miyukiBodyDropBound = true;

    function bindEditorBody() {
      var body = editor.getBody();

      if (!body || $(body).data('miyuki-body-drop-bound')) {
        return;
      }

      $(body)
        .data('miyuki-body-drop-bound', true)
        .on('dragenter.miyukiBodyDrop dragover.miyukiBodyDrop', function (event) {
          event.preventDefault();
          event.stopPropagation();
          getBodyEditorWrap(editorId).addClass('is-dragover');
        })
        .on('dragleave.miyukiBodyDrop', function (event) {
          event.preventDefault();
          event.stopPropagation();
          getBodyEditorWrap(editorId).removeClass('is-dragover');
        })
        .on('drop.miyukiBodyDrop', function (event) {
          handleBodyEditorDrop(event, editorId);
        });
    }

    if (editor.initialized) {
      bindEditorBody();
    }

    editor.on('init', bindEditorBody);
  }

  function setupBodyEditorDrops() {
    bodyEditorIds().forEach(function (editorId) {
      var $wrap = getBodyEditorWrap(editorId);

      if (!$wrap.length) {
        return;
      }

      $wrap.addClass('miyuki-body-editor-drop').attr('data-body-editor-id', editorId);
      $('#' + editorId + '_ifr').addClass('miyuki-body-editor-iframe').attr('data-body-editor-id', editorId);
      bindTinyMceBodyDrop(editorId);
    });
  }

  function bindDropUpload(selector, type) {
    $(document).on('dragenter dragover', selector, function (event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).addClass('is-dragover');
    });

    $(document).on('dragleave', selector, function (event) {
      event.preventDefault();
      event.stopPropagation();
      $(this).removeClass('is-dragover');
    });

    $(document).on('drop', selector, function (event) {
      event.preventDefault();
      event.stopPropagation();

      var $target = $(this);
      var $box = type === 'main' ? getImageContext($target) : getGalleryContext($target);
      var files = filesFromEvent(event);

      $target.removeClass('is-dragover');

      if (!files.length) {
        setUploadStatus($target, '画像ファイルをドラッグしてください。');
        return;
      }

      if (type === 'main') {
        files = files.slice(0, 1);
      }

      uploadFilesSequential($target, files, function (attachment) {
        if (type === 'main') {
          setMainImage($box, attachment);
        } else {
          addGalleryAttachment($box, attachment);
        }
      }).done(function () {
        clearUploadStatus($target);
      }).fail(function (message) {
        setUploadStatus($target, typeof message === 'string' ? message : 'アップロードに失敗しました。');
      });
    });
  }

  $('.miyuki-main-image-select').on('click', function () {
    var $box = getImageContext($(this));
    var frame = wp.media({
      title: 'メイン画像を選択',
      button: { text: 'この画像を使う' },
      library: { type: 'image' },
      multiple: false
    });

    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      setMainImage($box, attachment);
    });

    frame.open();
  });

  $('.miyuki-main-image-remove').on('click', function () {
    var $box = getImageContext($(this));
    $box.find('.miyuki-main-image-input').val('');
    if ($box.hasClass('miyuki-works-easy-form') || $box.hasClass('miyuki-image-upload-field')) {
      $box.find('.miyuki-main-image-preview').html(mainEmptyHtml());
    } else {
      $box.find('.miyuki-main-image-preview').empty();
    }
  });

  $('.miyuki-gallery-select').on('click', function () {
    var $box = getGalleryContext($(this));
    var $preview = $box.find('.miyuki-gallery-preview').first();
    var currentIds = ($box.find('.miyuki-gallery-input').first().val() || '').split(',').filter(Boolean);
    var frame = wp.media({
      title: '施工写真を選択',
      button: { text: '写真を追加' },
      library: { type: 'image' },
      multiple: true
    });

    frame.on('select', function () {
      frame.state().get('selection').each(function (item) {
        var attachment = item.toJSON();
        if (currentIds.indexOf(attachment.id.toString()) === -1) {
          currentIds.push(attachment.id.toString());
          $preview.find('.miyuki-gallery-empty').remove();
          $preview.append(createGalleryItem(attachment));
        }
      });

      updateGalleryInput($box);
    });

    frame.open();
  });

  $('.miyuki-gallery-preview').on('click', '.miyuki-gallery-remove', function () {
    var $box = getGalleryContext($(this));
    $(this).closest('.miyuki-gallery-item').remove();
    updateGalleryInput($box);
  });

  $('.miyuki-gallery-clear').on('click', function () {
    var $box = getGalleryContext($(this));
    $box.find('.miyuki-gallery-preview').first().empty();
    $box.find('.miyuki-gallery-input').first().val('');
    updateGalleryInput($box);
  });

  bindDropUpload('.miyuki-main-image-preview[data-drop-target="main"]', 'main');
  bindDropUpload('.miyuki-gallery-preview[data-drop-target="gallery"]', 'gallery');

  $(document).on('dragenter dragover', '.miyuki-body-editor-drop, .miyuki-body-image-drop, .miyuki-body-editor-iframe', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var editorId = $(this).attr('data-body-editor-id');

    $(this).addClass('is-dragover');
    getBodyEditorWrap(editorId).addClass('is-dragover');
  });

  $(document).on('dragleave', '.miyuki-body-editor-drop, .miyuki-body-image-drop, .miyuki-body-editor-iframe', function (event) {
    event.preventDefault();
    event.stopPropagation();
    var editorId = $(this).attr('data-body-editor-id');

    $(this).removeClass('is-dragover');
    getBodyEditorWrap(editorId).removeClass('is-dragover');
  });

  $(document).on('drop', '.miyuki-body-editor-drop, .miyuki-body-image-drop, .miyuki-body-editor-iframe', function (event) {
    $(this).removeClass('is-dragover');
    handleBodyEditorDrop(event, $(this).attr('data-body-editor-id'));
  });

  setupBodyEditorDrops();
  setTimeout(setupBodyEditorDrops, 400);
  setTimeout(setupBodyEditorDrops, 1200);

  if (window.tinymce && window.tinymce.on) {
    window.tinymce.on('AddEditor', function (event) {
      if (event && event.editor && bodyEditorIds().indexOf(event.editor.id) !== -1) {
        setupBodyEditorDrops();
      }
    });
  }
})(jQuery);
