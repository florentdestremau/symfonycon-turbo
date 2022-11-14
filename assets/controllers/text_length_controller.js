import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
  static targets = ['textarea', 'counter'];

  onChange = () => {
    this.calculate();
  };

  calculate = () => {
    const textLength = this.textareaTarget.value.length
    this.counterTarget.innerText = `${textLength} characters`;
    this.counterTarget.classList.toggle('text-warning', textLength < 10);
  };
}
