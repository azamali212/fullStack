import { Provider } from 'react-redux'; // Import the Provider
import { store } from '@/lib/store';

import "../styles/globals.css";  // Your global styles

export default function App({ Component, pageProps }) {
  return (
    <Provider store={store}>  {/* Wrap your entire app with the Provider */}
      <Component {...pageProps} />
    </Provider>
  );
}