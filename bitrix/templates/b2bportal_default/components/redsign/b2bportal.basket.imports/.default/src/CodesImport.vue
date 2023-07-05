<template>
  <div>
    <code
        ref="editor"
        contenteditable="true"
        class="form-control"
        style="min-height: 200px;overflow: auto;"
        :data-placeholder="messages.RS_B2BPORTAL_BI_CATALOG_PLACEHOLDER"
        @input="handleInput"
        @blur="handleBlur"
        v-html="displayContent"
    >
    </code>

    <div class="mt-4 pull-right">
      <button type="button" class="btn btn-outline-brand" data-dismiss="modal">{{ messages.RS_B2BPORTAL_BI_MODAL_CANCEL }}</button>
      <button type="button" class="btn btn-primary" @click="addtobasket">{{ messages.RS_B2BPORTAL_BI_MODAL_IMPORT }} </button>
    </div>
  </div>
</template>

<script>
import { checkExistsCodes, addtobasket } from './api.js';
import _escape from 'lodash/escape';

const DEFAULT_ADDTOBASKET_QUANTITY = 1;

export default {
  props: {
    signedParameters: {
      type: String,
      default: ''
    }
  },

  data()
  {
    return {
      content: '',
      displayContent: '',
      checkedCodes: {}
    };
  },

  computed: {

    messages()
    {
      return (
          Object.freeze(
              Object.keys(BX.message).filter(message => message.startsWith('RS_B2BPORTAL_BI'))
                  .reduce((obj, message) => { obj[message.slice(message)] = BX.message(message); return obj; }, {})
          )
      );
    },

    codes()
    {
      return this.content
          .split('\n')
          .map(codeValue => codeValue.trim())
          .filter(codeValue =>  codeValue !== '');
    },

  },

  mounted()
  {
    this.$refs.editor.addEventListener("paste", function(e) {
      e.preventDefault();

      var text = '';

      if (typeof (e.originalEvent || e).clipboardData === 'undefined')
      {
        text = window.clipboardData.getData('Text');
      }
      else
      {
        text = (e.originalEvent || e).clipboardData.getData('text/plain');
      }

      if (document.queryCommandSupported('insertHTML'))
      {
        text = text.replace(/\r?\n/g, '<br>');
        document.execCommand("insertHTML", false, text);
      }
      else
      {
        document.execCommand("paste", false, text);
      }
    });

    this.$refs.editor.addEventListener('input', e => {

      if (e.target.textContent)
      {
        e.target.dataset.divPlaceholderContent = 'true';
      }
      else
      {
        delete(e.target.dataset.divPlaceholderContent);
      }

    });
  },

  methods: {

    handleInput(e)
    {
      const selection = document.getSelection();
      const selNode = selection.anchorNode;

      if (selNode.nodeType == Node.TEXT_NODE && selNode.parentNode.tagName != 'CODE')
      {
        selNode.parentNode.setAttribute('class', '');
      }


      this.content = e.target.innerText;
    },

    handleBlur(e)
    {
      this.check();
    },

    async check()
    {
      const newCodes = this.codes.filter(code => !this.checkedCodes.hasOwnProperty(code));

      if (newCodes.length > 0)
      {
        const foundCodes = await checkExistsCodes({
          codes: newCodes,
          signedParameters: this.signedParameters
        });

        newCodes.forEach((codeValue) => {
          this.checkedCodes[codeValue] = foundCodes.includes(codeValue);
        });
      }

      this.updateDisplayContent();
    },

    updateDisplayContent()
    {
      let html = '';

      for(let code of this.codes)
      {
        const isFound = !!this.checkedCodes[code];
        html += '<div class="' + (isFound ? 'text-success': 'text-danger') + '">' + _escape(code) + ' ' + '</div>'
      }

      this.displayContent = html;
    },

    removeCodeFromContent(code)
    {
      this.content = this.content
          .replace(new RegExp('^.*' + code + '.*$', 'mg'), '')
          .replace('\n\r?', '');
    },

    prepareData()
    {
      const data = {};

      for (let code of this.codes)
      {
        data[code] = DEFAULT_ADDTOBASKET_QUANTITY;
      }

      return data;
    },

    async addtobasket()
    {
      if (!this.codes.length)
      {
        return;
      }

      KTApp.block(document.querySelector('.modal.show'));

      const result = await addtobasket({
        data: this.prepareData(),
        signedParameters: this.signedParameters
      });

      for (let i in result)
      {
        if (!result.hasOwnProperty(i))
        {
          continue;
        }

        if (result[i].isSuccess)
        {
          toastr.success(`${i}: ${result[i].message}`);
          this.removeCodeFromContent(result[i].code);
        }
        else
        {
          window.toastr.error(`${i}: ${result[i].message}`);
        }
      }

      KTApp.unblock(document.querySelector('.modal.show'));
      this.updateDisplayContent();
      this.$store.dispatch('cart/fetch');
    }
  }
}
</script>

<style lang="scss" scoped>
code[data-placeholder]:not(:focus):not([data-div-placeholder-content]):before {
  content: attr(data-placeholder);
  float: left;
  margin-left: 2px;
  color: #a1a8c3;
  white-space: pre;
}
</style>