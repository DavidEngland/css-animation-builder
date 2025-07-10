module.exports = {
  testEnvironment: 'jsdom',
  roots: ['<rootDir>/assets/js', '<rootDir>/tests'],
  testMatch: [
    '**/__tests__/**/*.{js,jsx,ts,tsx}',
    '**/*.(test|spec).{js,jsx,ts,tsx}'
  ],
  transform: {
    '^.+\\.(js|jsx|ts|tsx)$': 'babel-jest',
    '^.+\\.(css|scss|sass)$': 'identity-obj-proxy'
  },
  moduleNameMapping: {
    '\\.(css|scss|sass)$': 'identity-obj-proxy'
  },
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  collectCoverageFrom: [
    'assets/js/**/*.{js,jsx,ts,tsx}',
    '!assets/js/**/*.d.ts',
    '!assets/js/**/index.js'
  ],
  coverageDirectory: 'coverage',
  coverageReporters: ['text', 'lcov', 'html']
};
