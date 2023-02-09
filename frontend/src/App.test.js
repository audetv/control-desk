import App from './App';
import { createRenderer } from 'react-dom/test-utils';
import * as ShallowRenderer from 'react-test-renderer/shallow';

test('renders learn react link', () => {
  ShallowRenderer.render(<App />)

  // const h1Element = screen.getByText(/Control Desk/i);
  // expect(h1Element).toBeInTheDocument();
});
