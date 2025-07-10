// Jest setup file
import 'jest-dom/extend-expect';

// Mock CSS imports
jest.mock('*.css', () => ({}));
jest.mock('*.scss', () => ({}));

// Set up DOM environment
Object.defineProperty(window, 'matchMedia', {
  writable: true,
  value: jest.fn().mockImplementation(query => ({
    matches: false,
    media: query,
    onchange: null,
    addListener: jest.fn(), // Deprecated
    removeListener: jest.fn(), // Deprecated
    addEventListener: jest.fn(),
    removeEventListener: jest.fn(),
    dispatchEvent: jest.fn(),
  })),
});

// Mock document.execCommand
Object.defineProperty(document, 'execCommand', {
  writable: true,
  value: jest.fn(() => true),
});

// Global test utilities
global.createMockElement = (tag = 'div', id = null) => {
  const element = document.createElement(tag);
  if (id) element.id = id;
  return element;
};

global.createMockContainer = () => {
  const container = createMockElement('div', 'test-container');
  document.body.appendChild(container);
  return container;
};
